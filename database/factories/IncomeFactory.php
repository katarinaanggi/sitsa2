<?php

namespace Database\Factories;

use App\Models\Income;
use Illuminate\Database\Eloquent\Factories\Factory;

class IncomeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Income::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nama' => $this->faker->text(10),
            'tanggal' => $this->faker->date(),
            'jumlah' => $this->faker->numberBetween(0, 100),
            'total' => $this->faker->numberBetween(1000, 10000000),
            'deskripsi' => $this->faker->sentence(),
        ];
    }
}
