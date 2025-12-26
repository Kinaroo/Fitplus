<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TidurUser extends Model
{
    protected $table = 'tidur_user';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'user_id','jam_tidur','jam_bangun','durasi_jam','tanggal','kualitas_tidur','fase_tidur'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function analisis()
    {
        if ($this->durasi_jam < 6) return "Kurang tidur";
        if ($this->durasi_jam <= 8) return "Normal";
        return "Tidur berlebihan";
    }
}
