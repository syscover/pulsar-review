<?php namespace Syscover\Review\GraphQL\Inputs;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class CommentInput extends GraphQLType {

    protected $attributes = [
        'name'          => 'CommentInput',
        'description'   => 'Comment of review'
    ];

    protected $inputObject = true;

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::int(),
                'description' => 'The index of comment'
            ],
            'review_id' => [
                'type' => Type::int(),
                'description' => 'review id that belong this comment'
            ],
            'date' => [
                'type' => Type::string(),
                'description' => 'Date of comment'
            ],
            'owner_id' => [
                'type' => Type::int(),
                'description' => 'Type of owner, object or customer'
            ],
            'name' => [
                'type' => Type::string(),
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
                'type' => Type::boolean(),
                'description' => 'Check if comment is validated'
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