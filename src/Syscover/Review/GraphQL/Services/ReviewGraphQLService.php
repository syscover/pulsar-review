<?php namespace Syscover\Review\GraphQL\Services;

use Syscover\Core\GraphQL\Services\CoreGraphQLService;
use Syscover\Review\Models\Review;
use Syscover\Review\Services\ReviewService;

class ReviewGraphQLService extends CoreGraphQLService
{
    protected $modelClassName = Review::class;
    protected $serviceClassName = ReviewService::class;

    public function resolveAction($root, array $args)
    {
        $this->service->action($args['object'], $args['action_id']);
    }
}