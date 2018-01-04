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

        $response['review'] = Review::where('id', decrypt($parameters['slug']))->first();
        if(! $response['review']) abort(404);

        return view('review::web.content.review', $response);
    }
}
