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
    protected $fillable     = ['name', 'email_template', 'default_score', 'mailing_days', 'expiration_days'];

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