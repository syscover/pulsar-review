<?php namespace Syscover\Review\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CustomerHasReview extends Mailable
{
    use Queueable, SerializesModels;

    public $mSubject;
    public $mView;
    public $url;
    public $review;

    /**
     * Review constructor.
     * @param $mSubject
     * @param $mView
     * @param $review
     */
    public function __construct($mSubject, $mView, $review)
    {
        $this->mSubject = $mSubject;
        $this->mView    = $mView;
        $this->review   = $review;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject($this->mSubject);

        return $this->view($this->mView);
    }
}
