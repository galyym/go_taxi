<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'model' => Str::random(12),
            'government_number' => Str::random(12),
            'color' => Str::random(12),
            "passenger_seats" => rand(1, 10),
            'drivers_card_front' => Str::random(12),
            'drivers_card_back' => Str::random(12),
            'technical_certificate' => Str::random(12),
            'car_photo' => Str::random(12),
            'selfie_drivers_card' => Str::random(12),
            'user_id' => 1,
            'driver_id' => 1,
        ];
    }
}
