<?php

namespace Database\Factories;

use App\Models\Pesan;
use Illuminate\Database\Eloquent\Factories\Factory;

class PesanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pesan::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        do {
            $user_id = rand(1, 21);
            $teman_id = rand(1, 21);
        } while ($user_id === $teman_id);
        return [
            "user_id" => $user_id,
            "teman_id" => $teman_id,
            "text" => $this->faker->sentence,
            "dikirim_pada" => time(),
            "voice" => NULL
        ];
    }
}
