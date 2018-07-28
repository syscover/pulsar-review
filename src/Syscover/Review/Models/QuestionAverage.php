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
    protected $fillable     = ['poll_id', 'question_id', 'reviews', 'total', 'average'];

    private static $rules   = [];

    public static function validate($data)
    {
        return Validator::make($data, static::$rules);
	}

    public function question()
    {
        return $this->hasOne(Question::class, 'id', 'question_id');
    }

    public function poll()
    {
        return $this->hasOne(Poll::class, 'id', 'poll_id');
    }
}