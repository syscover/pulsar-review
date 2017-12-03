<?php namespace Syscover\Review\Services;

use Carbon\Carbon;
use Syscover\Review\Models\Review;

class Cron
{
    public static function checkMailingReview()
    {
        $reviews = Review::builder()
            ->where('completed', false)
            ->where('mailing', '<', Carbon::now())
            ->limit(50) // TODO, set config to limit 10/50/100/200/500
            ->get();


    }
    
    public static function checkDeleteReview()
    {
        Review::builder()
            ->where('completed', false)
            ->where('expiration', '<', Carbon::now())
            ->delete();
    }
}