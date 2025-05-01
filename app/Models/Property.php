<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PropertyImage;

class Property extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'price',
        'location',
        'status',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images_url()
    {
        return $this->hasMany(PropertyImage::class, 'property_id', 'id');
    }

    public function images()
    {
        return $this->hasMany(PropertyImage::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function favoredBy()
    {
        return $this->belongsToMany(User::class, 'favorites', 'property_id', 'user_id');
    }
}
