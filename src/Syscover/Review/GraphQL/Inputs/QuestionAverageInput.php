<?php namespace Syscover\Review\GraphQL\Inputs;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class QuestionAverageInput extends GraphQLType {

    protected $attributes = [
        'name'          => 'QuestionAverageInput',
        'description'   => 'Average for question'
    ];

    protected $inputObject = true;

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::int(),
                'description' => 'The index of review'
            ],
            'question_id' => [
                'type' => Type::int(),
                'description' => 'Question that belong this average'
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