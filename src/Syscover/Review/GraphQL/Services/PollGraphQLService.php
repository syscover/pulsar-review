<?php namespace Syscover\Review\GraphQL\Services;

use Syscover\Core\GraphQL\Services\CoreGraphQLService;
use Syscover\Review\Models\Poll;
use Syscover\Review\Services\PollService;

class PollGraphQLService extends CoreGraphQLService
{
    protected $model = Poll::class;
    protected $service = PollService::class;
}