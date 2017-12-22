<?php namespace Syscover\Review\GraphQL\Queries;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use Syscover\Core\Services\SQLService;
use Syscover\Review\Models\ObjectAverage;

class ObjectAverageQuery extends Query
{
    protected $attributes = [
        'name'          => 'AverageQuery',
        'description'   => 'Query to get average'
    ];

    public function type()
    {
        return GraphQL::type('ReviewObjectAverage');
    }

    public function args()
    {
        return [
            'sql' => [
                'name'          => 'sql',
                'type'          => Type::listOf(GraphQL::type('CoreSQLQueryInput')),
                'description'   => 'Field to add SQL operations'
            ]
        ];
    }

    public function resolve($root, $args)
    {
        $query = SQLService::getQueryFiltered(ObjectAverage::builder(), $args['sql']);

        return $query->first();
    }
}