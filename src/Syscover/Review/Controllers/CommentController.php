<?php namespace Syscover\Review\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;
use Syscover\Admin\Models\User;
use Syscover\Review\Models\Review;
use Syscover\Review\Services\CommentService;
use Syscover\Review\Notifications\Comment as CommentNotification;
use Syscover\Review\Mails\Comment as MailComment;

class CommentController extends BaseController
{
    public function store(Request $request)
    {
        $data = $request->all();
        $data['validated'] = ! cache('review_validate_comments');

        $comment = CommentService::create($data);

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
            // notification to customer or object owner
            $review = Review::find($request->input('review_id'));

            // TODO, check that  customer_email or object_email exist, and been a validate email
            Mail::to($comment->owner_id === 1 ? $review->customer_email : $review->object_email)
                ->send(new MailComment(
                    'Ruralka: Tienes un comentario de ' . $comment->name,
                    'review::emails.content.comment',
                    //$review->email_template ? $review->email_template : 'review::emails.content.review',
                    $comment
                ));
        }
    }
}
