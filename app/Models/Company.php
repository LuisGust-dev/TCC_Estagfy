<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Company extends Model
{
    protected $fillable = [
        'user_id',
        'cnpj',
        'phone',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobs()
{
    return $this->hasMany(Job::class);
}

    public function applications()
    {
        return $this->hasManyThrough(Application::class, Job::class);
    }

}
