<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Event;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    protected $model = Event::class;
   
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'start' => $this->faker->dateTimeBetween('+1 day', '+1 week'),
            'end' => $this->faker->dateTimeBetween('+1 week', '+2 weeks'),
            'color' => $this->faker->randomElement(['red', 'blue', 'green']),
            'user_id' => User::factory()->create()->id,
        ];
    }
}
