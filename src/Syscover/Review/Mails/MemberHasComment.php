<?php namespace Syscover\Review\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Syscover\Review\Models\Comment;

class MemberHasComment extends Mailable
{
    use Queueable, SerializesModels;

    public $comment;

    /**
     * Review constructor.
     * @param $comment
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject($this->comment->email_subject);

        return $this->view($this->comment->email_template ? $this->comment->email_template : 'review::mails.content.member_has_comment');
    }
}
