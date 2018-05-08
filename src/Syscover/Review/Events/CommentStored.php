<?php namespace Syscover\Review\Events;

use Syscover\Review\Models\Comment;

class CommentStored
{
    public $comment;

    /**
     * Create a new event instance.
     *
     * @param  Booking  $booking
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }
}