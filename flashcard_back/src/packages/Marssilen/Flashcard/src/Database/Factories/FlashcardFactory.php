<?php

namespace Marssilen\Flashcard\Database\Factories;

use Marssilen\Flashcard\Models\Flashcard;
use Illuminate\Database\Eloquent\Factories\Factory;

class FlashcardFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Flashcard::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'question' => $this->faker->word(),
            'answer' => $this->faker->word()
        ];
    }
}
