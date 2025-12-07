<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TargetUser extends Model
{
    protected $table = 'target_user';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'user_id','target_berat','target_kalori_harian','target_tidur'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
