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
            'text' => [
                'type' => Type::string(),
                'description' => 'Text of comment'
            ],
            'validated' => [
                'type' => Type::boolean(),
                'description' => 'Check if comment is validated'
            ]
        ];
    }
}