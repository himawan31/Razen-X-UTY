<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $fillable = [
        'property_id',
        'document_type',
        'document_url',
    ];
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
