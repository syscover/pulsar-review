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
    protected $fillable     = ['review_id', 'date', 'owner_id', 'name', 'email', 'text', 'validated'];
    protected $casts        = [
        'owner_id' => 'int'
    ];
    public $with            = ['review'];

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

    public function review()
    {
        return $this->hasOne(Review::class, 'id', 'review_id');
    }
}