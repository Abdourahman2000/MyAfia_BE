<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // List of places
        $places = ['Alrahma', 'Peltier', 'Soudani', 'Heron', 'Cheiko'];

        // Random user type (either 'admin' or 'agent')
        $type = $this->faker->randomElement(['admin', 'agent']);

        // Set place to 'DEV/DBA' if type is 'admin', otherwise pick a random place
        $place = $type === 'admin' ? 'DEV/DBA' : $this->faker->randomElement($places);

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            // 'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),

            'password' => Hash::make('test'), // Same password for all users
            'temp_password' => 1,
            'place' => $place,
            'type' => $type,
            'blocked_status' => null,
            'blocked_reason' => null,
            'taken_by' => 'Mohamed Zaki', // Same registered_by for all users
            'last_login_at' => null,
            'photo' => null,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
