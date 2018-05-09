<?php namespace Syscover\Review\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Syscover\Review\Services\CommentService;

class CommentController extends BaseController
{
    public function store(Request $request)
    {
        CommentService::store($request->all());
    }
}
