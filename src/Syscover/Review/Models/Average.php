<?php namespace Syscover\Review\Models;

use Illuminate\Support\Facades\Validator;
use Syscover\Core\Models\CoreModel;

/**
 * Class Average
 * @package Syscover\Review\Models
 */

class Average extends CoreModel
{
	protected $table        = 'review_average';
    protected $fillable     = ['poll_id', 'object_id', 'object_type', 'name', 'reviews', 'average'];

    private static $rules   = [
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