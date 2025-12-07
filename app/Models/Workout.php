<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    protected $table = 'exercises';
    public $timestamps = false;

    protected $fillable = [
        'COL 1', 'COL 2', 'COL 3', 'COL 4', 'COL 5', 'COL 6', 
        'COL 7', 'COL 8', 'COL 9', 'COL 10', 'COL 11', 'COL 12'
    ];

    public function scopeByMuscle($query, $muscle)
    {
        return $query->where('COL 6', $muscle);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('COL 2', $type);
    }

    public function scopeByLevel($query, $level)
    {
        return $query->where('COL 3', $level);
    }

    // Get exercise name
    public function getName()
    {
        return $this->attributes['COL 1'] ?? 'Unknown Exercise';
    }

    // Get force type (push/pull)
    public function getForce()
    {
        return $this->attributes['COL 2'] ?? 'unknown';
    }

    // Get difficulty level
    public function getLevel()
    {
        return $this->attributes['COL 3'] ?? 'beginner';
    }

    // Get primary muscle
    public function getMuscle()
    {
        return $this->attributes['COL 6'] ?? 'unknown';
    }

    // Get category
    public function getCategory()
    {
        return $this->attributes['COL 12'] ?? 'strength';
    }
}