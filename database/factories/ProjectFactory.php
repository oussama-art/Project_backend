<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        return [
            'title'       => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'user_id'     => User::factory(), // relation owner
            'created_at'  => now(),
            'updated_at'  => now(),
        ];
    }
}
