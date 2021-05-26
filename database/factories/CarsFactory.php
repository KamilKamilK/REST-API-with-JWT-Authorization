<?php

namespace Database\Factories;

use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Car::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'mark'=>$this->faker->sentence,
            'description'=>$this->faker->paragraph,
            'completed'=>rand(0,1),
            'created_by' => rand(1,10)
        ];
    }
}
