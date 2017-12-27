<?php namespace Syscover\Review\Models;

use Illuminate\Support\Facades\Validator;
use Syscover\Core\Models\CoreModel;

/**
 * Class QuestionAverage
 * @package Syscover\Review\Models
 */

class QuestionAverage extends CoreModel
{
	protected $table        = 'review_question_average';
    protected $fillable     = ['question_id', 'reviews', 'total', 'average'];

    private static $rules   = [];

    public static function validate($data)
    {
        return Validator::make($data, static::$rules);
	}

    public function scopeBuilder($query)
    {
        return $query;
    }

    public function question()
    {
        return $this->hasOne(Question::class, 'id', 'question_id');
    }
}