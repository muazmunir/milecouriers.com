<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentStatusHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipment_id',
        'status',
        'status_description',
    ];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }
}
