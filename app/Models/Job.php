<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

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
        'flow_type',
        'period_start',
        'period_end',
        'closed_at',
        'salary',
        'requirements',
    ];

    protected $casts = [
        'requirements' => 'array',
        'vacancies' => 'integer',
        'period_start' => 'date',
        'period_end' => 'date',
        'closed_at' => 'datetime',
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
        $today = Carbon::today()->toDateString();

        return $query
            ->whereNull('closed_at')
            ->whereRaw(
                "(select count(*) from applications where applications.job_id = jobs.id and applications.status = 'aprovado') < jobs.vacancies"
            )
            ->where(function (Builder $periodQuery) use ($today) {
                $periodQuery->where('flow_type', 'continuous')
                    ->orWhere(function (Builder $definedPeriod) use ($today) {
                        $definedPeriod->where('flow_type', 'defined_period')
                            ->whereDate('period_start', '<=', $today)
                            ->whereDate('period_end', '>=', $today);
                    });
            });
    }

    public function isWithinDefinedPeriod(?Carbon $date = null): bool
    {
        if ($this->flow_type !== 'defined_period') {
            return true;
        }

        if (!$this->period_start || !$this->period_end) {
            return false;
        }

        $date = $date ?: Carbon::today();

        return $date->between($this->period_start, $this->period_end);
    }

    public static function normalizeArea(?string $value): string
    {
        if ($value === null) {
            return '';
        }

        return (string) Str::of($value)
            ->ascii()
            ->lower()
            ->squish();
    }

    public function matchesCourse(?string $course): bool
    {
        return static::normalizeArea($this->area) !== ''
            && static::normalizeArea($this->area) === static::normalizeArea($course);
    }

}
