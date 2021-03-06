<?php namespace Syscover\Review\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Syscover\Review\Models\Review;
use Syscover\Review\Mails\CustomerHasReview;

class CronService
{
    public static function checkMailingReview()
    {
        info('Call Syscover\Review\Services\CronService::checkMailingReview function');

        $reviews = Review::builder()
            ->where('completed', false)
            ->where('sent', false)
            ->where('mailing', '<', Carbon::now(config('app.timezone'))->toDateTimeString())
            ->get();

        foreach ($reviews as $review)
        {
            Mail::to($review->customer_email)->queue(new CustomerHasReview($review));
        }

        // mark review like sent true
        Review::whereIn('id', $reviews->pluck('id'))->update([
            'sent' => true
        ]);
    }
    
    public static function checkDeleteReview()
    {
        info('Call Syscover\Review\Services\CronService::checkDeleteReview function');

        Review::builder()
            ->where('completed', false)
            ->where('expiration', '<', Carbon::now(config('app.timezone'))->toDateTimeString())
            ->delete();
    }
}