<?php namespace Syscover\Review\Models;

use Illuminate\Support\Facades\Validator;
use Syscover\Core\Models\CoreModel;

/**
 * Class Question
 * @package Syscover\Review\Models
 */

class Question extends CoreModel
{
	protected $table        = 'review_question';
    protected $fillable     = ['id', 'lang_id', 'poll_id', 'name', 'description', 'type_id', 'high_score'];

    private static $rules   = [
        'name' => 'required'
    ];

    public static function validate($data)
    {
        return Validator::make($data, static::$rules);
	}

    public function scopeBuilder($query)
    {
        return $query;
    }
}