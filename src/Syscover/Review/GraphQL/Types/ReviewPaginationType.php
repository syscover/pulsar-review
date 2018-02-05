<?php namespace Syscover\Review\GraphQL\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Syscover\Core\Services\SQLService;
use Folklore\GraphQL\Support\Type as GraphQLType;

class ReviewPaginationType extends GraphQLType
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

    public function resolveObjectsField($object, $args)
    {
        // get query ordered and limited
        $query = SQLService::getQueryOrderedAndLimited($object->query, $args['sql']);

        // get objects filtered
        $objects = $query->get();

        return $objects;
    }
}