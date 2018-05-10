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
    protected $fillable     = ['name', 'send_notification', 'validate', 'default_score', 'mailing_days', 'expiration_days', 'review_route', 'comment_route', 'review_email_template', 'comment_email_template'];
    public $with            = ['questions'];
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

    public function questions()
    {
        return $this->hasMany(Question::class, 'poll_id');
    }

    public function reviews()
    {
        return $this->morphMany(
                Review::class,
                'object',
                'object_type',
                'object_id',
                'id'
            )
            ->where('admin_attachment.lang_id', $this->lang_id)
            ->orderBy('sort', 'asc');
    }
}