<?php namespace Syscover\Review\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;
use Syscover\Admin\Models\User;
use Syscover\Review\Events\CommentStored;
use Syscover\Review\Models\Review;
use Syscover\Review\Services\CommentService;
use Syscover\Review\Notifications\CommentValidateModerator as CommentNotification;
use Syscover\Review\Mails\MemberHasComment;

class CommentController extends BaseController
{
    public function store(Request $request)
    {
        $review = Review::find($request->input('review_id'));

        $comment = CommentService::create([
                'review_id'         => $request->input('review_id'),
                'owner_id'          => $request->input('owner_id'),
                'name'              => $request->input('name'),
                'email'             => $request->input('email'),
                'comment'           => $request->input('comment'),
                'validated'         => ! cache('review_validate_comments'),
                'email_template'    => $review->poll->comment_email_template ? $review->poll->comment_email_template : 'review::mails.content.member_has_comment',
                'email_subject'     => $request->input('email_subject'),
            ])
            ->fresh(); // fresh object to get date created in database

        // create url for comment
        $comment->comment_url = $review->poll->comment_route ?
            route($review->poll->comment_route, ['slug' => encrypt(['review_id' => $comment->review->id, 'owner_id' => $comment->owner_id === 1 ? 2 : 1 ])]) :
            route('pulsar.review.review_show', ['slug' => encrypt(['review_id' => $comment->review->id, 'owner_id' => $comment->owner_id === 1 ? 2 : 1 ])]); // default route

        $comment->save();

        Log::info('Create new Syscover\Review\Models\Comment from Syscover\Review\Controllers\CommentController.', ['id' => $comment->id]);

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
            Mail::to($comment->owner_id === 1 ? $comment->review->customer_email : $comment->review->object_email)
                ->queue(new MemberHasComment($comment));
        }
    }
}
