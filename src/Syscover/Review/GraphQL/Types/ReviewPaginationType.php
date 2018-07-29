<?php namespace Syscover\Review\GraphQL\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Syscover\Core\GraphQL\Types\ObjectPaginationType;


class ReviewPaginationType extends ObjectPaginationType
{
    protected $attributes = [
        'name'          => 'ReviewPaginationType',
        'description'   => 'Pagination for database reviews'
    ];

    public function fields()
    {
        return [
            'total' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The total records'
            ],
            'filtered' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'N records filtered'
            ],
            'objects' => [
                'type' => Type::listOf(GraphQL::type('ReviewReview')),
                'description' => 'List of reviews',
                'args' => [
                    'sql' => [
                        'type' => Type::listOf(GraphQL::type('CoreSQLQueryInput')),
                        'description' => 'Field to add SQL operations'
                    ]
                ]
            ]
        ];
    }
}