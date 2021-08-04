<?php

namespace Database\Factories;

use App\Models\TsumiageItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TsumiageItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TsumiageItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
        ];
    }
}
