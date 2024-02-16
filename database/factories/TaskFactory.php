<?php

namespace Database\Factories;

use App\Enums\TaskStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(8),
            'description' => fake()->paragraph(3),
            'status' => fake()->randomElement(TaskStatus::cases()),
        ];
    }

    public function status(TaskStatus $status): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => $status,
        ]);
    }

    public function assigned_user(User $user): static
    {
        return $this->state(fn (array $attributes) => [
            'assigned_user_id' => $user->id,
        ]);
    }
}
