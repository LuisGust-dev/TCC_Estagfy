<?php

namespace App\Models;

use App\Support\TopHiringCompanyPhotoStorage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopHiringCompany extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'course',
        'description',
        'photo',
        'created_by',
    ];

    protected $appends = [
        'photo_url',
    ];

    public function getPhotoUrlAttribute(): ?string
    {
        return TopHiringCompanyPhotoStorage::publicUrl($this->photo);
    }
}
