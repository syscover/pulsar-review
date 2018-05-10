<?php namespace Syscover\Review\GraphQL\Inputs;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class PollInput extends GraphQLType
{
    protected $attributes = [
        'name'          => 'PollType',
        'description'   => 'Poll for reviews'
    ];

    protected $inputObject = true;

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::int(),
                'description' => 'The index of article'
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Name of poll'
            ],
            'send_notification' => [
                'type' => Type::boolean(),
                'description' => 'Check if sends notification to object_mail field from review table'
            ],
            'validate' => [
                'type' => Type::boolean(),
                'description' => 'Check if has validate review by moderator'
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
            'review_route' => [
                'type' => Type::string(),
                'description' => 'Route to get public review to fill poll'
            ],
            'review_email_template' => [
                'type' => Type::string(),
                'description' => 'Email template that will set the review to send to the customer'
            ],
            'comment_email_template' => [
                'type' => Type::string(),
                'description' => 'Email template that will set the comment to send to the customer'
            ]
        ];
    }
}