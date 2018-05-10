<?php namespace Syscover\Review\GraphQL\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class ReviewType extends GraphQLType {

    protected $attributes = [
        'name'          => 'ReviewType',
        'description'   => 'Review for reviews'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
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
            'poll' => [
                'type' => Type::nonNull(GraphQL::type('ReviewPoll')),
                'description' => 'Poll of review'
            ],
            'responses' => [
                'type' => Type::nonNull(Type::listOf(GraphQL::type('ReviewResponse'))),
                'description' => 'Responses of review'
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
            'object_email' => [
                'type' => Type::string(),
                'description' => 'Email where will be sent the notifications and comments if has data'
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
                'type' => Type::nonNull(Type::boolean()),
                'description' => 'Check if is a verified customer'
            ],
            'email_subject' => [
                'type' => Type::string(),
                'description' => 'Subject of email sent to customer'
            ],
            'review_url' => [
                'type' => Type::string(),
                'description' => 'URL to access public review to fill review for the customer'
            ],
            'review_completed_url' => [
                'type' => Type::string(),
                'description' => 'URL to access public review to show review for owner'
            ],
            'completed' => [
                'type' => Type::nonNull(Type::boolean()),
                'description' => 'Check if the review was completed for the customer'
            ],
            'validated' => [
                'type' => Type::nonNull(Type::boolean()),
                'description' => 'Check if review is added'
            ],
            'average' => [
                'type' => Type::float(),
                'description' => 'Average of all responses',
                'resolve' => function ($object, $args) {
                    return $object->average;
                }
            ],
            'total' => [
                'type' => Type::float(),
                'description' => 'Total of all responses'
            ],
            'mailing' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Date when review will be send to customer'
            ],
            'sent' => [
                'type' => Type::nonNull(Type::boolean()),
                'description' => 'Check if was sent email to customer'
            ],
            'expiration' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Date when review will be delete if is not completed'
            ],
            'comments' => [
                'type' => Type::nonNull(Type::listOf(GraphQL::type('ReviewComment'))),
                'description' => 'Comments that belong this review'
            ]
        ];
    }

    public function resolveAverageField($object, $args)
    {
        return $object->average;
    }

    public function resolveTotalField($object, $args)
    {
        return $object->total;
    }
}