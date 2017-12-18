<?php namespace Syscover\Review\GraphQL\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class ResponseType extends GraphQLType {

    protected $attributes = [
        'name'          => 'ResponseType',
        'description'   => 'Response for poll'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The id of response'
            ],
            'review_id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Review that belong this response'
            ],
            'question_id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Question that belong this response'
            ],
            'questions' => [
                'type' => Type::nonNull(Type::listOf(GraphQL::type('ReviewQuestion'))),
                'description' => 'Questions multi-languages object that belong this response'
            ],
            'score' => [
                'type' => Type::int(),
                'description' => 'Score for this response'
            ],
            'text' => [
                'type' => Type::string(),
                'description' => 'Text for this response'
            ]
        ];
    }
}