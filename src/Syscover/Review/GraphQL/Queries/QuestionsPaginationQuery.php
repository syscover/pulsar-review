<?php namespace Syscover\Review\GraphQL\Queries;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use Syscover\Review\Models\Question;

class QuestionsPaginationQuery extends Query
{
    protected $attributes = [
        'name'          => 'QuestionsPaginationQuery',
        'description'   => 'Query to get list questions'
    ];

    public function type()
    {
        return GraphQL::type('CoreObjectPagination');
    }

    public function args()
    {
        return [
            'filters' => [
                'name'          => 'filters',
                'type'          => Type::listOf(GraphQL::type('CoreSQLQueryInput')),
                'description'   => 'to filter queries'
            ],
            'sql' => [
                'name'          => 'sql',
                'type'          => Type::listOf(GraphQL::type('CoreSQLQueryInput')),
                'description'   => 'Field to add SQL operations'
            ]
        ];
    }

    public function resolve($root, $args)
    {
        return (Object) [
            // set setEagerLoads to clean eager loads to use FOUND_ROWS() MySql Function
            'query' => Question::calculateFoundRows()->builder()->setEagerLoads([])
        ];
    }
}