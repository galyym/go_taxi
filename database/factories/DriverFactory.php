<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DriverFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => Str::random(10),
            'phone_number' => Str::random(12),
            'email' => Str::random(6),
            'user_id' => 1,
            'car_id' => 1
        ];
    }
}
