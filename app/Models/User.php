<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'akun_user';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'nama',
        'email',
        'password_hash',
        'jenis_kelamin',
        'tanggal_lahir',
        'tinggi',
        'berat',
        'tingkat_aktivitas',
        'target_berat',
        'tanggal_daftar',
        'umur',
        'is_admin'
    ];

    protected $hidden = ['password_hash'];

    /* RELATIONS */
    public function aktivitas()
    {
        return $this->hasMany(AktivitasUser::class, 'user_id');
    }

    public function makanan()
    {
        return $this->hasMany(MakananUser::class, 'user_id');
    }

    public function target()
    {
        return $this->hasMany(TargetUser::class, 'user_id');
    }

    public function tidur()
    {
        return $this->hasMany(TidurUser::class, 'user_id');
    }

    public function rekomendasi()
    {
        return $this->hasMany(RekomendasiUser::class, 'user_id');
    }

    public function workout()
    {
        return $this->hasMany(Workout::class, 'user_id');
    }

    public function tantangan()
    {
        return $this->hasMany(TantanganUser::class, 'user_id');
    }

    /* METHODS */
    public function register(array $data)
    {
        $data['password_hash'] = Hash::make($data['password']);
        unset($data['password']);
        return self::create($data);
    }

    public static function authenticate($email, $password)
    {
        $user = self::where('email', $email)->first();
        if (!$user)
            return null;

        if (Hash::check($password, $user->password_hash)) {
            return $user;
        }

        return null;
    }

    public function resetPassword(string $newPassword)
    {
        $this->password_hash = Hash::make($newPassword);
        $this->save();
    }

    public function hitungUmur(): int
    {
        if (!$this->tanggal_lahir)
            return 0;
        return \Carbon\Carbon::parse($this->tanggal_lahir)->age;
    }
    public function hitungKaloriHarian()
    {
        $umur = Carbon::parse($this->tanggal_lahir)->age;

        $bmr = ($this->jenis_kelamin == 'L')
            ? 10 * $this->berat + 6.25 * $this->tinggi - 5 * $umur + 5
            : 10 * $this->berat + 6.25 * $this->tinggi - 5 * $umur - 161;

        // Convert activity level string to numeric multiplier
        $activityMultiplier = match ($this->tingkat_aktivitas) {
            'low' => 1.2,      // Sedentary: little or no exercise
            'mid' => 1.55,     // Moderate: exercise 3-4 days/week
            'high' => 1.9,     // Very active: intense exercise 5+ days/week
            default => 1.5,    // Default middle ground
        };

        return $bmr * $activityMultiplier;
    }
    public function hitungKaloriHarianTarget(): float
    {
        $maintenance = $this->hitungKaloriHarian() ?? 2000;
        $imt = $this->hitungIMT();

        if ($imt < 18.5) {
            // Gain weight: +300-500 kcal (use 400 as middle ground)
            return $maintenance + 400;
        } elseif ($imt < 25) {
            // Maintain: ±0
            return $maintenance;
        } elseif ($imt < 30) {
            // Lose weight: -300-500 kcal (use 400 as middle ground)
            return $maintenance - 400;
        } else {
            // Significant weight loss: -500-800 kcal (use 650 as middle ground)
            return $maintenance - 650;
        }
    }

    public function hitungKaloriHariIni()
    {
        return $this->makanan()
            ->whereDate('tanggal', today())
            ->join('info_makanan', 'makanan_user.makanan_id', '=', 'info_makanan.id')
            ->sum(DB::raw('porsi * info_makanan.kalori'));
    }

    public function hitungIMT(): float
    {
        if ($this->tinggi <= 0)
            return 0.0;
        return $this->berat / pow($this->tinggi / 100, 2);
    }

    public function kategoriIMT(): string
    {
        $imt = $this->hitungIMT();

        if ($imt <= 0)
            return 'Unknown';
        if ($imt < 18.5)
            return 'Kurus';
        if ($imt < 25)
            return 'Normal';
        if ($imt < 30)
            return 'Gemuk';
        return 'Obesitas';
    }

    protected static function boot()
    {
        parent::boot();

        // Automatically calculate and set umur before saving
        static::saving(function ($user) {
            if ($user->tanggal_lahir) {
                $user->umur = \Carbon\Carbon::parse($user->tanggal_lahir)->age;
            }
        });
    }

}
