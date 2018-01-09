<?php namespace Syscover\Review\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;
use Syscover\Admin\Models\User;
use Syscover\Review\Services\CommentService;
use Syscover\Review\Notifications\Comment as CommentNotification;
use Syscover\Review\Mails\MemberHasComment;

class CommentController extends BaseController
{
    public function store(Request $request)
    {
        $data = $request->all();
        $data['validated'] = ! cache('review_validate_comments');

        $comment = CommentService::create($data)->fresh(); // fresh object to get date created in database

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
            // TODO, check that  customer_email or object_email exist, and been a validate email
            Mail::to($comment->owner_id === 1 ? $comment->review->customer_email : $comment->review->object_email)
                ->send(new MemberHasComment(
                    'Ruralka: Tienes un comentario de ' . $comment->name,
                    'review::mails.content.member_has_comment',
                    //$review->email_template ? $review->email_template : 'review::mails.content.review',
                    $comment
                ));
        }
    }
}