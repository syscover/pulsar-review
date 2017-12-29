<?php namespace Syscover\Review\GraphQL\Inputs;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class ObjectAverageInput extends GraphQLType {

    protected $attributes = [
        'name'          => 'AverageInput',
        'description'   => 'Average for object'
    ];

    protected $inputObject = true;

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::int(),
                'description' => 'The index of review'
            ],
            'poll_id' => [
                'type' => Type::int(),
                'description' => 'Poll that belong this average'
            ],
            'object_id' => [
                'type' =>  Type::int(),
                'description' => 'Object that belong this average'
            ],
            'object_type' => [
                'type' => Type::string(),
                'description' => 'Object class name that belong this average'
            ],
            'object_name' => [
                'type' => Type::string(),
                'description' => 'Object name that belong this average'
            ],
            'reviews' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Number of reviews computed'
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