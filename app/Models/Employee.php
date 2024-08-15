<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'image',
        'phone',
        'division_id',
        'position',
    ];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['name'] ?? null, function ($query, $name) {
            $query->where('name', 'like', '%'.$name.'%');
        });

        $query->when($filters['division_id'] ?? null, function ($query, $division_id) {
            $query->where('division_id', $division_id);
        });
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
