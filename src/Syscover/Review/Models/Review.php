<?php namespace Syscover\Review\Models;

use Illuminate\Support\Facades\Validator;
use Syscover\Core\Models\CoreModel;

/**
 * Class Review
 * @package Syscover\Review\Models
 */

class Review extends CoreModel
{
	protected $table        = 'review_review';
    protected $fillable     = ['date', 'poll_id', 'object_id', 'object_type', 'object_name', 'object_email', 'customer_id', 'customer_name', 'customer_email', 'customer_verified', 'email_subject', 'completed', 'validated', 'average', 'mailing', 'expiration'];
    public $with            = ['poll'];

    private static $rules   = [];

    public static function validate($data)
    {
        return Validator::make($data, static::$rules);
	}

    public function scopeBuilder($query)
    {
        return $query;
    }

    public function poll()
    {
        return $this->hasOne(Poll::class, 'id', 'poll_id');
    }
}