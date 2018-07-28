<?php namespace Syscover\Review\GraphQL\Queries;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use Syscover\Review\Models\Review;

class ReviewsPaginationQuery extends Query
{
    protected $attributes = [
        'name'          => 'ReviewsPaginationQuery',
        'description'   => 'Query to get list reviews'
    ];

    public function type()
    {
        return GraphQL::type('ReviewReviewPagination');
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
        return (Object) [
            // set setEagerLoads to clean eager loads to use FOUND_ROWS() MySql Function
            'query' => Review::calculateFoundRows()->builder()
        ];
    }
}