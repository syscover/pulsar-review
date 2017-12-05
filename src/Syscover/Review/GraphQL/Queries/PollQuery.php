<?php namespace Syscover\Review\GraphQL\Queries;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use Syscover\Core\Services\SQLService;
use Syscover\Review\Models\Poll;

class PollQuery extends Query
{
    protected $attributes = [
        'name'          => 'PollQuery',
        'description'   => 'Query to get poll'
    ];

    public function type()
    {
        return GraphQL::type('ReviewPoll');
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
        $query = SQLService::getQueryFiltered(Poll::builder(), $args['sql']);

        return $query->first();
    }
}