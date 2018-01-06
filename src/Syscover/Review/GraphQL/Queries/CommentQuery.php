<?php namespace Syscover\Review\GraphQL\Queries;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use Syscover\Core\Services\SQLService;
use Syscover\Review\Models\Comment;

class CommentQuery extends Query
{
    protected $attributes = [
        'name'          => 'CommentQuery',
        'description'   => 'Query to get comment'
    ];

    public function type()
    {
        return GraphQL::type('ReviewComment');
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
        $query = SQLService::getQueryFiltered(Comment::builder(), $args['sql']);

        return $query->first();
    }
}