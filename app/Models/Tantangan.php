<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tantangan extends Model
{
    protected $table = 'tantangan';
    protected $fillable = [
        'nama','deskripsi','target_value','unit','tanggal_mulai','tanggal_selesai','created_by'
    ];
    public $timestamps = true;

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignments()
    {
        return $this->hasMany(TantanganUser::class, 'tantangan_id');
    }
}