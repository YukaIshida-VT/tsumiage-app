<?php

namespace Database\Factories;

use App\Models\Tsumiage;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class TsumiageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tsumiage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'item' => $this->faker->name,
            'user_id' => User::factory(),
            'date' => $this->faker->date,
        ];
    }
}
