<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubRegion extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'translations',
        'region_id',
        'flag',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function countries()
    {
        return $this->hasMany(Country::class);
    }
}
