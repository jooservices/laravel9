<?php

namespace Modules\ATG\Database\factories;

use Faker\Provider\Fakecar;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\WithFaker;
use Modules\ATG\Models\Item;

class ItemFactory extends Factory
{
    use WithFaker;

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
        $this->setUpFaker();
        $this->faker->addProvider(new Fakecar($this->faker));
        return [
            'name' => $this->faker->vehicle,
            'model' => $this->faker->vehicleModel,
            'manufacturer' => $this->faker->vehicleBrand,
            'price' => $this->faker->randomFloat(2, 1, 1000),
        ];
    }
}

