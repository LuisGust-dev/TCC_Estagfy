<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Student extends Model
{
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
}
