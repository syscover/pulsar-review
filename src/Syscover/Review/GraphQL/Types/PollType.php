<?php namespace Syscover\Review\GraphQL\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class PollType extends GraphQLType {

    protected $attributes = [
        'name'          => 'PollType',
        'description'   => 'Poll for reviews'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The index of poll'
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Name of poll'
            ],
            'email_template' => [
                'type' => Type::string(),
                'description' => 'Email template that will be used'
            ],
            'send_notification' => [
                'type' => Type::boolean(),
                'description' => 'Check if sends notification to object_mail field from review table'
            ],
            'default_high_score' => [
                'type' => Type::int(),
                'description' => 'Max score by default for response'
            ],
            'mailing_days' => [
                'type' => Type::int(),
                'description' => 'Days that after register review, it will be sent'
            ],
            'expiration_days' => [
                'type' => Type::int(),
                'description' => 'Days that after register review, it will be delete if is not completed'
            ],
            'questions' => [
                'type' => Type::nonNull(Type::listOf(GraphQL::type('ReviewQuestion'))),
                'description' => 'Questions multi-languages object that belong this response'
            ],
        ];
    }
}