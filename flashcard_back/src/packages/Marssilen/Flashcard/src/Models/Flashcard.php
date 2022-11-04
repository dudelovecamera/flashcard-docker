<?php

namespace Marssilen\Flashcard\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Marssilen\Flashcard\Database\Factories\FlashcardFactory;
use Marssilen\Practice\Models\AnswerProxy;
use Illuminate\Database\Eloquent\Model;
use Marssilen\Flashcard\Contracts\Flashcard as FlashcardContract;

class Flashcard extends Model implements FlashcardContract
{
    use HasFactory;

    protected $fillable = [
        'question',
        'answer',
    ];

    /**
     * Get the answers that the flashcard owns.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers(): HasMany
    {
        return $this->hasMany(AnswerProxy::modelClass());
    }

    /**
     * Get the answers that the flashcard owns.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function last_answer(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(AnswerProxy::modelClass())->latest();
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return FlashcardFactory::new();
    }
}
