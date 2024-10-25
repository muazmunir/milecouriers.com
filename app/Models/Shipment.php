<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipment_number',
        'sender_id',
        'recipient_id',
        'origin_address',
        'destination_address',
        'shipment_date',
        'estimated_delivery_date',
        'actual_delivery_date',
        'status_id',
        'delivery_time_id',
        'payment_method_id',
        'shipping_mode_id',
        'service_mode_id',
        'driver_id'
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    public function items()
    {
        return $this->hasMany(ShipmentItem::class);
    }

    public function statusHistories()
    {
        return $this->hasMany(ShipmentStatusHistory::class);
    }

    public function tracking()
    {
        return $this->hasMany(ShipmentTracking::class);
    }
}
