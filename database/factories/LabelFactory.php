<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Label>
 */
class LabelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $faker_it = Faker\Factory::create('it_IT');
        $faker_en = Faker\Factory::create('en_GB');

        return [
            'label' => fake()->word(),
            'it' => $faker_it->realText(),
            'en' => $faker_en->realText(),
        ];
    }
}
