<?php namespace Syscover\Review\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;
use Syscover\Admin\Models\User;
use Syscover\Review\Models\Review;
use Syscover\Review\Models\Response;
use Syscover\Review\Notifications\Review as ReviewNotification;
use Syscover\Review\Notifications\ReviewOwnerObject as ReviewOwnerObjectNotification;
use Syscover\Review\Services\ObjectAverageService;
use Syscover\Review\Services\QuestionAverageService;

class ResponseController extends BaseController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function store(Request $request)
    {
        $review = Review::where('completed', false)->where('id', $request->input('review'))->first();
        if(! $review) abort(404);

        $now            = Carbon::now(config('app.timezone'))->toDateTimeString();
        $responses      = [];
        $scoreQuestions = 0;

        foreach ($review->poll->questions->where('lang_id', user_lang()) as $question) {
            $response = [
                'review_id'     => $review->id,
                'question_id'   => $question->id,
                'score'         => null,
                'text'          => null,
                'created_at'    => $now,
                'updated_at'    => $now,
            ];

            // question with score
            if($question->type_id === 1)
            {
                $response['score'] = $request->input('q' . $question->id);
                $scoreQuestions++;
            }

            // question with text
            if($question->type_id === 2)
            {
                $response['text'] = $request->input('q' . $question->id);
            }

            $responses[] = $response;
        }

        Response::insert($responses);

        // update review
        $responses          = collect($responses);
        $totalScore         = $responses->sum('score');
        $review->average    = $totalScore /  $scoreQuestions;
        $review->completed  = true;

        if(! $review->poll->validate)
        {
            // review is not validated by moderator
            ObjectAverageService::addAverage($review);
            QuestionAverageService::addAverage($review);

            // set review how validated
            $review->validated = true;

            if($review->poll->send_notification)
            {
                // send email notification to owner object
                Notification::route('mail', $review->object_email)
                    ->notify(new ReviewOwnerObjectNotification($review));
            }
        }

        $review->save();

        if($review->poll->validate)
        {
            $moderators = User::whereIn('id', cache('review_moderators'))->get();
            Notification::route('mail', $moderators->pluck('email'))
                ->notify(new ReviewNotification($review));
        }

        return redirect()->route($request->input('route'));
    }
}
