<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'title',
        'description',
        'location',
        'type',
        'salary',
        'requirements',
    ];

    protected $casts = [
        'requirements' => 'array',
    ];

    public function company()
    {
        return $this->belongsTo(\App\Models\Company::class);
    }

    public function applications()
    {
        return $this->hasMany(\App\Models\Application::class);
    }

}
