<?php namespace Syscover\Review\GraphQL\Queries;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use Syscover\Core\Services\SQLService;
use Syscover\Review\Models\Review;

class ReviewQuery extends Query
{
    protected $attributes = [
        'name'          => 'ReviewQuery',
        'description'   => 'Query to get review'
    ];

    public function type()
    {
        return GraphQL::type('ReviewReview');
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
        $query = SQLService::getQueryFiltered(Review::builder(), $args['sql']);

        return $query->first();
    }
}