<?php namespace Syscover\Review\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class QuestionAverageType extends GraphQLType {

    protected $attributes = [
        'name'          => 'QuestionAverageType',
        'description'   => 'Average for question'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The index of review'
            ],
            'question_id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Poll that belong this review'
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