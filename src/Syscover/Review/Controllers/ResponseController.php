<?php namespace Syscover\Review\Controllers;

use Illuminate\Http\Request;
use Syscover\Core\Controllers\CoreController;
use Syscover\Admin\Services\ActionService;
use Syscover\Admin\Models\Action;
use Syscover\Review\Mails\Review;
use Syscover\Review\Models\Response;

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
    public function storeResponse(Request $request)
    {
        $review = Review::find($request->input('review'));
        $responses = [];

        foreach ($review->poll->questions as $question) {
            $response = [
                'review_id'     => $review->id,
                'question_id'   => $question->id
            ];
            if($question->type_id === 1) $response['score'] = $request->input('q' . $question->id);
            if($question->type_id === 2) $response['text'] = $request->input('q' . $question->id);

            $responses[] = $response;
        }

        Response::insert($responses);
    }
}
