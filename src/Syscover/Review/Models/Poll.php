<?php namespace Syscover\Review\Models;

use Illuminate\Support\Facades\Validator;
use Syscover\Core\Models\CoreModel;

/**
 * Class Poll
 * @package Syscover\Review\Models
 */

class Poll extends CoreModel
{
	protected $table        = 'review_poll';
    protected $fillable     = ['id', 'name', 'email_template', 'default_score', 'mailing_days', 'expiration_days'];

    private static $rules   = [
        'name' => 'required|between:2,100'
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