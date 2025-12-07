<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekomendasiUser extends Model
{
    protected $table = 'rekomendasi_user';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'jenis', 'rekomendasi', 'tanggal'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
