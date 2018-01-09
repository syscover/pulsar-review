<?php namespace Syscover\Review\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Syscover\Review\Models\Review;

class CustomerHasReview extends Mailable
{
    use Queueable, SerializesModels;

    public $review;

    /**
     * Review constructor.
     * @param $review
     */
    public function __construct(Review $review)
    {
        $this->review = $review;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject($this->review->email_subject);

        return $this->view($this->review->email_template ? $this->review->email_template : 'review::mails.content.customer_has_review');
    }
}
