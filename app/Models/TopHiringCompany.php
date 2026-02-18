<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopHiringCompany extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'course',
        'description',
        'created_by',
    ];
}
