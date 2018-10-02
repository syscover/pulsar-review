<?php namespace Syscover\Review\GraphQL\Services;

use Syscover\Core\GraphQL\Services\CoreGraphQLService;
use Syscover\Review\Models\Poll;
use Syscover\Review\Services\PollService;

class PollGraphQLService extends CoreGraphQLService
{
    protected $modelClassName = Poll::class;
    protected $serviceClassName = PollService::class;
}