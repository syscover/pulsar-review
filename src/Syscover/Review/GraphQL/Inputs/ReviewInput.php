<?php namespace Syscover\Review\GraphQL\Inputs;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

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
            'customer_id' => [
                'type' => Type::int(),
                'description' => 'Customer that belong this review'
            ],
            'customer_name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Customer name that belong this review'
            ],
            'customer_email' => [
                'type' => Type::nonNull(Type::string()),
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
            'completed' => [
                'type' => Type::boolean(),
                'description' => 'Check if the review was completed for the customer'
            ],
            'validated' => [
                'type' => Type::boolean(),
                'description' => 'Check if review is added'
            ],
            'average' => [
                'type' => Type::float(),
                'description' => 'Average of all responses'
            ],
            'mailing' => [
                'type' => Type::string(),
                'description' => 'Date when review will be send to customer'
            ],
            'expiration' => [
                'type' => Type::string(),
                'description' => 'Date when review will be delete if is not completed'
            ]
        ];
    }
}