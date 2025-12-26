<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AktivitasUser extends Model
{
    protected $table = 'aktivitas_user';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'nama_aktivitas',
        'durasi_menit',
        'kalori_terbakar',
        'tanggal',
        'umur',
        'berat_badan',
        'tinggi_badan',
        'jam_tidur',
        'olahraga'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
