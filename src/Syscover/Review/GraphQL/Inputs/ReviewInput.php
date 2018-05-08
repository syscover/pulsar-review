<?php namespace Syscover\Review\GraphQL\Inputs;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;
use Syscover\Core\GraphQL\ScalarTypes\ObjectType;

class ReviewInput extends GraphQLType {

    protected $attributes = [
        'name'          => 'ReviewInput',
        'description'   => 'Review for reviews'
    ];

    protected $inputObject = true;

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::int(),
                'description' => 'The index of review'
            ],
            'date' => [
                'type' => Type::string(),
                'description' => 'Date of review'
            ],
            'poll_id' => [
                'type' => Type::int(),
                'description' => 'Poll that belong this review'
            ],
            'object_id' => [
                'type' =>  Type::int(),
                'description' => 'Object that belong this review'
            ],
            'object_type' => [
                'type' => Type::string(),
                'description' => 'Object class name that belong this review'
            ],
            'object_name' => [
                'type' => Type::string(),
                'description' => 'Object name that belong this review'
            ],
            'object_email' => [
                'type' => Type::string(),
                'description' => 'Email where will be sent the notifications and comments if has data'
            ],
            'customer_id' => [
                'type' => Type::int(),
                'description' => 'Customer that belong this review'
            ],
            'customer_name' => [
                'type' => Type::string(),
                'description' => 'Customer name that belong this review'
            ],
            'customer_email' => [
                'type' => Type::string(),
                'description' => 'Customer email that belong this review'
            ],
            'customer_verified' => [
                'type' => Type::boolean(),
                'description' => 'Check if is a verified customer'
            ],
            'email_subject' => [
                'type' => Type::string(),
                'description' => 'Subject of email sent to customer'
            ],
            'review_url' => [
                'type' => Type::string(),
                'description' => 'URL to access public review to fill poll'
            ],
            'completed' => [
                'type' => Type::boolean(),
                'description' => 'Check if the review was completed for the customer'
            ],
            'validated' => [
                'type' => Type::boolean(),
                'description' => 'Check if review is added'
            ],
            'mailing' => [
                'type' => Type::string(),
                'description' => 'Date when review will be send to customer'
            ],
            'sent' => [
                'type' => Type::boolean(),
                'description' => 'Check if was sent email to customer'
            ],
            'expiration' => [
                'type' => Type::string(),
                'description' => 'Date when review will be delete if is not completed'
            ],
            'responses' => [
                'type' => Type::listOf(app(ObjectType::class)),
                'description' => 'List of attachments added to article'
            ],
        ];
    }
}