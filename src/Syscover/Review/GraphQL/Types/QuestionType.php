<?php namespace Syscover\Review\GraphQL\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class QuestionType extends GraphQLType {

    protected $attributes = [
        'name'          => 'QuestionType',
        'description'   => 'Question for poll'
    ];

    public function fields()
    {
        return [
            'ix' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The index of question'
            ],
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The id of question'
            ],
            'lang_id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Lang of question'
            ],
            'poll_id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Poll that belong this question'
            ],
            'type_id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Question type, score, text or select'
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Name of question'
            ],
            'description' => [
                'type' => Type::string(),
                'description' => 'Description of question'
            ],
            'sort' => [
                'type' => Type::int(),
                'description' => 'Sort of question'
            ],
            'high_score' => [
                'type' => Type::int(),
                'description' => 'Max score that can to contain the review'
            ],
            'data_lang' => [
                'type' => Type::listOf(Type::string()),
                'description' => 'JSON string that contain information about object translations'
            ],
            'average' => [
                'type' => GraphQL::type('ReviewQuestionAverage'),
                'description' => 'Average of question'
            ]
        ];
    }
}