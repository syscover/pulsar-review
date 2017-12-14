<?php namespace Syscover\Review\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Syscover\Core\Controllers\CoreController;
use Syscover\Admin\Services\ActionService;
use Syscover\Admin\Models\Action;
use Syscover\Review\Models\Review;
use Syscover\Review\Models\Response;
use Syscover\Review\Services\AverageService;

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

            if($question->type_id === 1)
            {
                $response['score'] = $request->input('q' . $question->id);
                $scoreQuestions++;
            }

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
        $review->save();


        // SETTINGS NO VALIDATE REVIEWS
        //AverageService::addAverage($review);

        return redirect()->route($request->input('route'));
    }
}
