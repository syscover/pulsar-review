<?php namespace Syscover\Review\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Syscover\Review\Services\CommentService;

class CommentController extends BaseController
{
    public function store(Request $request)
    {
        CommentService::store($request->all());

        return redirect()->route('pulsar.review.review_show', ['slug' => encrypt([
            'review_id'         => $request->input('review_id'),
            'owner_type_id'     => $request->input('owner_type_id')
        ])])->with([
            'status' => 'success'
        ]);
    }
}
