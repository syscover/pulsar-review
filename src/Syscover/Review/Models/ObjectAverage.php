<?php namespace Syscover\Review\Models;

use Illuminate\Support\Facades\Validator;
use Syscover\Core\Models\CoreModel;

/**
 * Class ObjectAverage
 * @package Syscover\Review\Models
 */

class ObjectAverage extends CoreModel
{
	protected $table        = 'review_object_average';
    protected $fillable     = ['poll_id', 'object_id', 'object_type', 'object_name', 'reviews', 'total', 'average', 'fake_average'];
    public $with            = ['poll', 'question_averages'];

    private static $rules   = [];

    public static function validate($data)
    {
        return Validator::make($data, static::$rules);
	}

    public function poll()
    {
        return $this->hasOne(Poll::class, 'id', 'poll_id');
    }

    // Average of question from concrete object
    public function question_averages()
    {
        return $this->hasMany(ObjectQuestionAverage::class, 'object_id', 'object_id');
    }
}
