<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'title',
        'description',
        'location',
        'type',
        'area',
        'vacancies',
        'salary',
        'requirements',
    ];

    protected $casts = [
        'requirements' => 'array',
        'vacancies' => 'integer',
    ];

    public function company()
    {
        return $this->belongsTo(\App\Models\Company::class);
    }

    public function applications()
    {
        return $this->hasMany(\App\Models\Application::class);
    }

    public function approvedApplications()
    {
        return $this->hasMany(\App\Models\Application::class)->where('status', 'aprovado');
    }

    public function scopeOpenForApplications(Builder $query): Builder
    {
        return $query->whereRaw(
            "(select count(*) from applications where applications.job_id = jobs.id and applications.status = 'aprovado') < jobs.vacancies"
        );
    }

}
