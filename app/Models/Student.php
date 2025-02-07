<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nim',
        'ymd',
        'user_id',
    ];

    /**
     * Get the user that owns the student.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSearch($query, $filters)
    {
        if (!empty($filters['nim'])) {
            $query->where('nim', $filters['nim']);
        }

        if (!empty($filters['nama'])) {
            $query->where('nama', 'like', '%' . $filters['nama'] . '%');
        }

        if (!empty($filters['ymd'])) {
            $query->where('ymd', $filters['ymd']);
        }

        return $query;
    }
}
