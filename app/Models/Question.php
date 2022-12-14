<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property-read static $nextQuestion
 */
class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'survey_id',
        'next_question_id'
    ];

    /**
     * @return HasMany
     */
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * @return HasOne
     */
    public function nextQuestion(): HasOne
    {
        return $this->hasOne(self::class, 'id', 'next_question_id');
    }

    /**
     * @return HasOne
     */
    public function response(): HasOne
    {
        return $this->hasOne(AnswerQuestion::class, 'question_id', 'id')
            ->where('user_id', '=', auth()->id());
    }
}
