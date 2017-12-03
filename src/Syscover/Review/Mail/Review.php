<?php namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Review extends Mailable
{
    use Queueable, SerializesModels;

    public $mSubject;
    public $mView;
    public $mData;

    /**
     * Review constructor.
     * @param $mSubject
     * @param $mView
     * @param $mData
     */
    public function __construct($mSubject, $mView, $mData)
    {
        $this->subject  = $mSubject;
        $this->mView    = $mView;
        $this->mData    = collect($mData);
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
