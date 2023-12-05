<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\SuperAdmin;

class SuperAdminFactory extends Factory
{

    public function definition(): array
    {
        //DUDAS --> 
        return [
            'mail' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('secret'),
        ];
    }
}
