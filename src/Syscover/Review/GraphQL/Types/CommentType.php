<?php namespace Syscover\Review\GraphQL\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class CommentType extends GraphQLType {

    protected $attributes = [
        'name'          => 'CommentType',
        'description'   => 'Comment of review'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The index of comment'
            ],
            'review_id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'review id that belong this comment'
            ],
            'review' => [
                'type' => Type::nonNull(GraphQL::type('ReviewReview')),
                'description' => 'Review of comment'
            ],
            'date' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Date of comment'
            ],
            'owner_id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Type of owner, object or customer'
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Name of owner of this comment'
            ],
            'email' => [
                'type' => Type::string(),
                'description' => 'Email of owner of this comment'
            ],
            'comment' => [
                'type' => Type::string(),
                'description' => 'Text of comment'
            ],
            'validated' => [
                'type' => Type::nonNull(Type::boolean()),
                'description' => 'Check if comment is sent'
            ],
            'email_template' => [
                'type' => Type::string(),
                'description' => 'Email template that the client or owner will receive to see comments'
            ],
            'email_subject' => [
                'type' => Type::string(),
                'description' => 'Route to generate the url to access the comments from the email sent to the client / owner'
            ],
            'comment_url' => [
                'type' => Type::string(),
                'description' => 'Url to show the comment'
            ]
        ];
    }
}