<?php namespace Syscover\Review\Services;

use Illuminate\Support\Facades\Mail;
use Syscover\Review\Models\Comment;
use Syscover\Review\Mails\MemberHasComment as MailComment;

class CommentService
{
    public static function create($object)
    {
        CommentService::checkCreate($object);
        return Comment::create(CommentService::builder($object));
    }

    public static function update($object)
    {
        CommentService::checkUpdate($object);
        Comment::where('id', $object['id'])->update(CommentService::builder($object));

        return Comment::find($object['id']);
    }

    private static function builder($object)
    {
        $object = collect($object);
        return $object->only('review_id', 'date', 'owner_id', 'name', 'email', 'comment', 'validated', 'email_template', 'email_subject', 'comment_url')->toArray();
    }

    private static function checkCreate($object)
    {
        if(empty($object['review_id']))     throw new \Exception('You have to define a review_id field to create a comment');
        if(empty($object['owner_id']))      throw new \Exception('You have to define a owner_id field to create a comment');
        if(empty($object['name']))          throw new \Exception('You have to define a name field to create a comment');
        if(empty($object['email']))         throw new \Exception('You have to define a email field to create a comment');
        if(empty($object['comment']))       throw new \Exception('You have to define a comment field to create a comment');
    }

    private static function checkUpdate($object)
    {
        if(empty($object['id'])) throw new \Exception('You have to define a id field to update a comment');
    }

    public static function action($object, $actionId)
    {
        $comment        = Comment::find($object['id']);
        $comment->text  = $object['text'];

        // 1 - Update, validate comment and send email
        // 2 - Update, validate comment
        // 3 - Update, invalidate comment
        switch ($actionId)
        {
            case 1:
                $comment->validated = true;
                $comment->save();

                Mail::to($comment->owner_id === 1 ? $comment->review->customer_email : $comment->review->object_email)
                    ->queue(new MailComment($comment));
                break;
            case 2:
                $comment->validated = true;
                $comment->save();
                break;
            case 3:
                $comment->validated = false;
                $comment->save();
                break;
        }
    }
}