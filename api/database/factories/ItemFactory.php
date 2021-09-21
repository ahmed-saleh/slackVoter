<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;


class ItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Item::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'publisher' => $this->faker->company,
            'year' => '1996',
            'img_url' => 'https://upload.wikimedia.org/wikipedia/en/a/a7/KI2_flyer.jpg' // password
        ];
    }
}


