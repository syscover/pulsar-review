<?php namespace Syscover\Review\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;
use Syscover\Admin\Models\User;
use Syscover\Core\Controllers\CoreController;
use Syscover\Admin\Services\ActionService;
use Syscover\Admin\Models\Action;
use Syscover\Review\Models\Review;
use Syscover\Review\Models\Response;
use Syscover\Review\Notifications\Review as ReviewNotification;
use Syscover\Review\Services\ObjectAverageService;

class ResponseController extends CoreController
{
    protected $model = Action::class;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response['status'] = "success";
        $response['data']   = ActionService::create($request->all());

        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param   \Illuminate\Http\Request  $request
     * @return  \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $response['status'] = "success";
        $response['data']   = ActionService::update($request->all());

        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeResponses(Request $request)
    {
        $review         = Review::find($request->input('review'));
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

                // add question average
                //$question->average->
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

            // set review how validated
            $review->validated = true;
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
