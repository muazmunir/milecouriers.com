<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipment_id',
        'description',
        'type_of_packaging_id',
        'weight',
        'length',
        'width',
        'height',
        'declared_value',
    ];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }

    public function packagingType()
    {
        return $this->belongsTo(TypesOfPacking::class, 'type_of_packaging_id');
    }
}
