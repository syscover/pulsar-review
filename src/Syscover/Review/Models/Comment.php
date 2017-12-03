<?php namespace Syscover\Review\Models;

use Illuminate\Support\Facades\Validator;
use Syscover\Core\Models\CoreModel;

/**
 * Class Comment
 * @package Syscover\Review\Models
 */

class Comment extends CoreModel
{
	protected $table        = 'review_comment';
    protected $fillable     = ['review_id', 'date', 'customer_name', 'customer_email', 'text'];

    private static $rules   = [
        'customer_name' => 'required',
        'customer_email' => 'required|email',
        'text' => 'required'
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