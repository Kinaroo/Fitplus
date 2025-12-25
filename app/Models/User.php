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

    protected $table = 'users';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'nama','email','password','jenis_kelamin','tanggal_lahir',
        'tinggi','berat','tingkat_aktivitas','umur'
    ];

    protected $hidden = ['password'];

    /**
     * Override getAuthPassword to use password field
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Disable remember token since table doesn't have it
     */
    public function getRememberToken()
    {
        return null;
    }

    public function setRememberToken($value)
    {
        // Do nothing
    }

    public function getRememberTokenName()
    {
        return null;
    }

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
    protected static function boot()
    {
        parent::boot();
        
        // Password sudah di-hash di controller, jadi tidak perlu di-hash lagi di sini
    }

    public static function authenticate($email, $password)
    {
        $user = self::where('email', $email)->first();
        if (!$user) return null;

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

    public function hitungKaloriHarian()
    {
        $umur = Carbon::parse($this->tanggal_lahir)->age;

        $bmr = ($this->jenis_kelamin == 'L')
            ? 10 * $this->berat + 6.25 * $this->tinggi - 5 * $umur + 5
            : 10 * $this->berat + 6.25 * $this->tinggi - 5 * $umur - 161;

        return $bmr * ($this->tingkat_aktivitas ?? 1.55);
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
        if (!$this->tinggi || $this->tinggi <= 0) return 0.0;
        return $this->berat / pow($this->tinggi / 100, 2);
    }

    public function kategoriIMT(): string
    {
       $imt = $this->hitungIMT();

        if ($imt <= 0) return 'Unknown';
        if ($imt < 18.5) return 'Kurus';
        if ($imt < 25) return 'Normal';
        if ($imt < 30) return 'Gemuk';
       return 'Obesitas';
    }

}
