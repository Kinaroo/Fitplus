<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MakananUser extends Model
{
    protected $table = 'makanan_user';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'makanan_id',
        'tanggal',
        'porsi',
        'total_kalori'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function infoMakanan()
    {
        return $this->belongsTo(InfoMakanan::class, 'makanan_id');
    }

    public function hitungTotalKalori()
    {
        if ($this->infoMakanan) {
            $this->total_kalori = $this->infoMakanan->kalori * $this->porsi;
            $this->save();
        }
    }
}
