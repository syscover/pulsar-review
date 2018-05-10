<?php namespace Syscover\Review\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Syscover\Admin\Models\User;
use Syscover\Review\Events\CommentStored;
use Syscover\Review\Models\Comment;
use Syscover\Review\Mails\MemberHasComment as MailComment;
use Syscover\Review\Models\Review;
use Syscover\Review\Notifications\CommentValidateModerator as CommentNotification;
use Syscover\Review\Mails\MemberHasComment;

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
        return $object->only('review_id', 'date', 'owner_type_id', 'name', 'email', 'comment', 'validated', 'email_template', 'email_subject', 'comment_url')->toArray();
    }

    private static function checkCreate($object)
    {
        if(empty($object['review_id']))     throw new \Exception('You have to define a review_id field to create a comment');
        if(empty($object['owner_type_id'])) throw new \Exception('You have to define a owner_type_id field to create a comment');
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
        $comment            = Comment::find($object['id']);
        $comment->comment   = $object['comment'];

        // 1 - Update, validate comment and send email
        // 2 - Update, validate comment
        // 3 - Update, invalidate comment
        switch ($actionId)
        {
            case 1:
                $comment->validated = true;
                $comment->save();

                Mail::to($comment->owner_type_id === 1 ? $comment->review->customer_email : $comment->review->object_email)
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

    public static function store($object)
    {
        CommentService::checkCreate($object);

        // get review of comment
        $review = Review::find($object['review_id']);

        $comment = CommentService::create([
                'review_id'         => $object['review_id'],
                'owner_type_id'     => $object['owner_type_id'],
                'name'              => $object['name'],
                'email'             => $object['email'],
                'comment'           => $object['comment'],
                'validated'         => ! cache('review_validate_comments'),
                'email_template'    => $review->poll->comment_email_template ? $review->poll->comment_email_template : 'review::mails.content.member_has_comment',
                'email_subject'     => $object['email_subject']
            ])
            ->fresh(); // fresh object to get date created in database

        // create url for comment
        $comment->comment_url = $review->poll->review_route ?
            route($review->poll->review_route, ['slug' => encrypt(['review_id' => $comment->review->id, 'owner_type_id' => $comment->owner_type_id === 1 ? 2 : 1 ])]) :
            route('pulsar.review.review_show', ['slug' => encrypt(['review_id' => $comment->review->id, 'owner_type_id' => $comment->owner_type_id === 1 ? 2 : 1 ])]); // default route

        $comment->save();

        info('Create new Syscover\Review\Models\Comment from Syscover\Review\Controllers\CommentController.', ['id' => $comment->id]);

        // Fire event to change comment from public web
        event(new CommentStored($comment));

        // check if moderatos has to validate comment
        if(cache('review_validate_comments'))
        {

            // notification to moderators
            $moderators = User::whereIn('id', cache('review_moderators'))->get();
            Notification::route('mail', $moderators->pluck('email'))
                ->notify(new CommentNotification($comment));
        }
        else
        {
            // TODO, check that customer_email or object_email exist, and been a validate email
            Mail::to($comment->owner_type_id === 1 ? $comment->review->customer_email : $comment->review->object_email)
                ->queue(new MemberHasComment($comment));
        }
    }
}