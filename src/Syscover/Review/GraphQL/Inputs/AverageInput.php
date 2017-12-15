<?php namespace Syscover\Review\GraphQL\Inputs;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class AverageInput extends GraphQLType {

    protected $attributes = [
        'name'          => 'AverageInput',
        'description'   => 'Average for review'
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
                'type' => Type::nonNull(Type::int()),
                'description' => 'Poll that belong this review'
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