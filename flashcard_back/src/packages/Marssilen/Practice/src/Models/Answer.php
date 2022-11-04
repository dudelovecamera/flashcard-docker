<?php

namespace Marssilen\Practice\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Marssilen\Flashcard\Models\FlashcardProxy;
use Marssilen\Practice\Contracts\Answer as PracticeContract;

class Answer extends Model implements PracticeContract
{
    protected $fillable = [
        'answer',
        'is_correct',
        'flashcard_id',
        'user_id',
    ];

    /**
     * Get the flashcard that owns the answer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function flashcard(): BelongsTo
    {
        return $this->belongsTo(FlashcardProxy::modelClass());
    }
}
