<?php namespace Syscover\Review\GraphQL\Queries;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use Syscover\Core\Services\SQLService;
use Syscover\Review\Models\Question;

class QuestionQuery extends Query
{
    protected $attributes = [
        'name'          => 'QuestionQuery',
        'description'   => 'Query to get question'
    ];

    public function type()
    {
        return GraphQL::type('ReviewQuestion');
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
        $query = SQLService::getQueryFiltered(Question::builder(), $args['sql']);

        return $query->first();
    }
}