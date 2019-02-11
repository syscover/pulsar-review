<?php namespace Syscover\Review\GraphQL\Services;

use Syscover\Core\GraphQL\Services\CoreGraphQLService;
use Syscover\Review\Models\Poll;
use Syscover\Review\Services\PollService;

class PollGraphQLService extends CoreGraphQLService
{
    public function __construct(Poll $model, PollService $service)
    {
        $this->model = $model;
        $this->service = $service;
    }
}
