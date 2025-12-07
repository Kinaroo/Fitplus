<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InfoMakanan extends Model
{
    protected $table = 'info_makanan';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'nama_makanan',
        'kalori',
        'protein',
        'karbohidrat',
        'lemak',
    ];

    public function makananUser()
    {
        return $this->hasMany(MakananUser::class, 'makanan_id');
    }
}