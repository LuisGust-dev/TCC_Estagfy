<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Support\ResumeStorage;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cpf',
        'course',
        'period',
        'resume',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getResumeUrlAttribute(): ?string
    {
        return ResumeStorage::publicUrl($this->resume);
    }
}
