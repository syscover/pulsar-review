<?php namespace Syscover\Review\Models;

use Illuminate\Support\Facades\Validator;
use Syscover\Core\Models\CoreModel;
use Syscover\Admin\Traits\Translatable;

/**
 * Class Question
 * @package Syscover\Review\Models
 */

class Question extends CoreModel
{
    use Translatable;

	protected $table        = 'review_question';
    protected $primaryKey   = 'ix';
    protected $fillable     = ['id', 'lang_id', 'poll_id', 'type_id', 'name', 'description', 'sort', 'high_score', 'data_lang'];
    protected $casts        = [
        'data_lang' => 'array'
    ];
    public $with            = ['lang'];

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