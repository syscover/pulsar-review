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
    protected $fillable     = ['date', 'poll_id', 'object_id', 'object_type', 'customer_id', 'customer_name', 'customer_email', 'email_subject', 'verified', 'average', 'completed', 'mailing', 'expiration'];
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