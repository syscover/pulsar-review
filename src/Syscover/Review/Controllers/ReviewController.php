<?php namespace Syscover\Review\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Syscover\Review\Models\Review;

class ReviewController extends BaseController
{
    public function show(Request $request)
    {
        // get parameters from url route
        $parameters = $request->route()->parameters();

        // decrypt data, that contain owner_id and review_id
        $data = decrypt($parameters['slug']);

        // check data
        if(! is_array($data)) abort(404);
        if(! isset($data['review_id'])) abort(404);
        if(! isset($data['owner_id'])) abort(404);

        $response['review']     = Review::where('id', $data['review_id'])->first();
        $response['owner_id']   = $data['owner_id'];

        if(! $response['review']) abort(404);

        return view('review::web.content.review', $response);
    }
}
