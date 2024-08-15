<?php

namespace Database\Factories;

use App\Models\Division;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $division = Division::pluck('id')->toArray();

        return [
            'name' => $this->faker->name(),
            'image' => $this->faker->imageUrl(),
            'phone' => $this->faker->phoneNumber(),
            'division_id' => $this->faker->randomElement($division),
            'position' => $this->faker->jobTitle(),
        ];
    }
}
