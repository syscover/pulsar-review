<?php namespace Syscover\Review\GraphQL\Services;

use Syscover\Core\GraphQL\Services\CoreGraphQLService;
use Syscover\Review\Models\ObjectAverage;
use Syscover\Review\Services\ObjectAverageService;

class ObjectAverageGraphQLService extends CoreGraphQLService
{
    protected $modelClassName = ObjectAverage::class;
    protected $serviceClassName = ObjectAverageService::class;
}