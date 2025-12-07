<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TantanganUser extends Model
{
    protected $table = 'tantangan_user';
    protected $primaryKey = 'id';
    public $timestamps = true; // after migration

    protected $fillable = [
        'creator_user_id',
        'user_id',
        'nama_tantangan',
        'status',
        'target_type',
        'target_value',
        'progress_value',
        'workout_plan',
        'tanggal_mulai',
        'tanggal_selesai',
        'reward',
        'notes',
    ];

    protected $casts = [
        'workout_plan' => 'array',
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
        'target_value' => 'float',
        'progress_value' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function addProgress(float $amount)
    {
        $this->progress_value += $amount;
        // optional: clamp to target
        if ($this->target_value && $this->progress_value >= $this->target_value) {
            $this->progress_value = $this->target_value;
            $this->status = 'completed';
        } else {
            $this->status = 'active';
        }
        $this->save();
    }
}