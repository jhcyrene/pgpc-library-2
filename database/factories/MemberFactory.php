<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

class MemberFactory extends Factory
{
    protected $model = Member::class;

    public function definition(): array
    {
        return [
            'student_id_number' => fake()->unique()->numerify('202#-####'),
            'first_name' => fake()->firstName(),
            'middle_name' => fake()->randomElement([fake()->lastName(), null]),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'contact_num' => fake()->numerify('09#########'),
            'program' => fake()->randomElement(['BSIT', 'BSBA', 'BSED', 'BEED', 'BSHM']),
            'year_level' => fake()->randomElement(['1st Year', '2nd Year', '3rd Year', '4th Year']),
            'member_status_id' => 1,
        ];
    }
}
