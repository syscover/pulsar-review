<?php namespace Syscover\Review\GraphQL\Services;

use Syscover\Core\GraphQL\Services\CoreGraphQLService;
use Syscover\Review\Models\Review;
use Syscover\Review\Services\ReviewService;

class ReviewGraphQLService extends CoreGraphQLService
{
    public function __construct(Review $model, ReviewService $service)
    {
        $this->model = $model;
        $this->service = $service;
    }

    public function resolveAction($root, array $args)
    {
        $this->service->action($args['payload'], $args['action_id']);
    }
}
