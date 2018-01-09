<?php namespace Syscover\Review\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MemberHasComment extends Mailable
{
    use Queueable, SerializesModels;

    public $mSubject;
    public $mView;
    public $comment;
    public $url;

    /**
     * Review constructor.
     * @param $mSubject
     * @param $mView
     * @param $review
     */
    public function __construct($mSubject, $mView, $comment)
    {
        $this->mSubject = $mSubject;
        $this->mView    = $mView;
        $this->comment   = $comment;
        //$this->url      = route('fill.review-' . user_lang(), ['slug' => encrypt($review->id)]);
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
