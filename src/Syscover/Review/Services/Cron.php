<?php namespace Syscover\Review\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Syscover\Review\Models\Review;
use Syscover\Review\Mails\Review as MailReview;

class Cron
{
    public static function checkMailingReview()
    {
        $reviews = Review::builder()
            ->where('completed', false)
            ->where('sent', false)
            ->where('mailing', '<', Carbon::now(config('app.timezone'))->toDateTimeString())
            ->limit(50) // TODO, set config to limit 10/50/100/200/500
            ->get();

        foreach ($reviews as $review)
        {
            Mail::to($review->customer_email)
                ->send(new MailReview(
                    $review->email_subject,
                    $review->email_template ? $review->email_template : 'review::emails.content.review',
                    $review
                ));
        }

        // mark review like sent true
        Review::whereIn('id', $reviews->pluck('id'))->update([
            'sent' => true
        ]);
    }
    
    public static function checkDeleteReview()
    {
        Review::builder()
            ->where('completed', false)
            ->where('expiration', '<', Carbon::now(config('app.timezone'))->toDateTimeString())
            ->delete();
    }
}