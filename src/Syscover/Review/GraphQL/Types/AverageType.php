<?php namespace Syscover\Review\GraphQL\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class AverageType extends GraphQLType {

    protected $attributes = [
        'name'          => 'AverageType',
        'description'   => 'Average for review'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The index of review'
            ],
            'poll_id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Poll that belong this review'
            ],
            'poll' => [
                'type' => Type::nonNull(GraphQL::type('ReviewPoll')),
                'description' => 'Poll of average'
            ],
            'object_id' => [
                'type' =>  Type::nonNull(Type::int()),
                'description' => 'Object that belong this review'
            ],
            'object_type' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Object class name that belong this review'
            ],
            'object_name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Object name that belong this review'
            ],
            'reviews' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Number of reviews computeds'
            ],
            'total' => [
                'type' => Type::nonNull(Type::float()),
                'description' => 'Total score'
            ],
            'average' => [
                'type' => Type::nonNull(Type::float()),
                'description' => 'Average of all responses'
            ]
        ];
    }
}