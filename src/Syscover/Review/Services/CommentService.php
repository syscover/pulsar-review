<?php namespace Syscover\Review\Services;

use Syscover\Review\Models\Comment;

class CommentService
{
    /**
     * @param array     $object     contain properties of poll
     * @return \Syscover\Review\Models\Comment
     */
    public static function create($object)
    {
        return Comment::create($object);
    }
}