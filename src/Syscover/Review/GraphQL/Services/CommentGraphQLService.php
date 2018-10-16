<?php namespace Syscover\Review\GraphQL\Services;

use Syscover\Core\GraphQL\Services\CoreGraphQLService;
use Syscover\Review\Models\Comment;
use Syscover\Review\Services\CommentService;

class CommentGraphQLService extends CoreGraphQLService
{
    protected $modelClassName = Comment::class;
    protected $serviceClassName = CommentService::class;

    public function resolveAction($root, array $args)
    {
        $this->service->action($args['payload'], $args['action_id']);
    }
}