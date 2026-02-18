<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'student_id',
        'company_id',
        'sender_id',
        'message',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relacionamentos
    |--------------------------------------------------------------------------
    */

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function company()
    {
        return $this->belongsTo(User::class, 'company_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
