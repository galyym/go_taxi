<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        "from_address",
        "to_address",
        "price",
        "departure_time",
        "passenger_count",
        "salon",
        "round_trip",
        "luggage",
        "for_another_client",
        "comment",
        "user_id"
    ];
}
