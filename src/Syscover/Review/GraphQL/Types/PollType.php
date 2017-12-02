<?php namespace Syscover\Review\GraphQL\Types;

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
                'description' => 'The index of article'
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Name of poll'
            ],
            'email_template' => [
                'type' => Type::string(),
                'description' => 'Email template that will be used'
            ],
            'default_score' => [
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
            ]
        ];
    }
}