<?php namespace Syscover\Review\Models;

use Illuminate\Support\Facades\Validator;
use Syscover\Core\Models\CoreModel;

/**
 * Class Response
 * @package Syscover\Review\Models
 */

class Response extends CoreModel
{
	protected $table        = 'review_response';
    protected $fillable     = ['review_id', 'question_id', 'score', 'text'];
    public $with            = ['questions'];

    private static $rules   = [];

    public static function validate($data)
    {
        return Validator::make($data, static::$rules);
	}

    public function scopeBuilder($query)
    {
        return $query;
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'id', 'question_id');
    }
}