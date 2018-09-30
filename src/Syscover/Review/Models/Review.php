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
    protected $fillable     = ['date', 'poll_id', 'object_id', 'object_type', 'object_name', 'object_email', 'customer_id', 'customer_name', 'customer_email', 'customer_verified', 'email_template', 'email_subject', 'review_url', 'review_completed_url', 'completed', 'validated', 'mailing', 'sent', 'expiration'];
    public $with            = ['poll', 'responses'];
    protected $appends      = ['average', 'total'];

    private static $rules   = [];

    public function __get($name)
    {
        switch ($name)
        {
            case 'average':
                $scoreQuestions = 0;

                foreach($this->responses as $response)
                {
                    // is response type score
                    if($response->questions->first()->type_id === 1) $scoreQuestions++;
                }
                return $scoreQuestions ===  0 ? 0 : $this->total / $scoreQuestions;
                break;

            case 'total':
                $total = 0;
                foreach($this->responses as $response)
                {
                    // is response type score
                    if($response->questions->first()->type_id === 1) $total += $response->score;
                }
                return $total;
                break;
        }

        return parent::__get($name);
    }

    public static function validate($data)
    {
        return Validator::make($data, static::$rules);
	}

    /**
     * Relations
     */
    public function poll()
    {
        return $this->hasOne(Poll::class, 'id', 'poll_id');
    }

    public function responses()
    {
        return $this->hasMany(Response::class, 'review_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'review_id', 'id');
    }

    /**
     * Accessors
     */
    public function getAverageAttribute()
    {
        return $this->average;
    }

    public function getTotalAttribute()
    {
        return $this->total;
    }
}