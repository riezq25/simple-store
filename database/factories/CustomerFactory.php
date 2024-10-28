<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition(): array
    {
        return [
            'customer_name' => fake()
                ->unique()
                ->name(),
            'phone_number'  => fake()
                ->numerify('628#########'),
            'email'         => fake()
                ->unique()
                ->email(),
            'address'       => fake()->address(),
            'birth_date'    => fake()->date(),
            'city_code'     => City::inRandomOrder()
                ->first()->city_code,
        ];
    }
}
