<?php namespace Syscover\Review\GraphQL\Mutations;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use Syscover\Review\Models\Comment;
use Syscover\Review\Services\CommentService;
use Syscover\Core\Services\SQLService;

class CommentMutation extends Mutation
{
    public function type()
    {
        return GraphQL::type('ReviewComment');
    }
}

class AddCommentMutation extends CommentMutation
{
    protected $attributes = [
        'name' => 'addComment',
        'description' => 'Add new review'
    ];

    public function args()
    {
        return [
            'object' => [
                'name' => 'object',
                'type' => Type::nonNull(GraphQL::type('ReviewCommentInput'))
            ]
        ];
    }

    public function resolve($root, $args)
    {
        return CommentService::create($args['object']);
    }
}

class UpdateCommentMutation extends CommentMutation
{
    protected $attributes = [
        'name' => 'updateComment',
        'description' => 'Update review'
    ];

    public function args()
    {
        return [
            'object' => [
                'name' => 'object',
                'type' => Type::nonNull(GraphQL::type('ReviewCommentInput'))
            ]
        ];
    }

    public function resolve($root, $args)
    {
        return CommentService::update($args['object']);
    }
}

class DeleteCommentMutation extends CommentMutation
{
    protected $attributes = [
        'name' => 'deleteComment',
        'description' => 'Delete review'
    ];

    public function args()
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::nonNull(Type::int())
            ]
        ];
    }

    public function resolve($root, $args)
    {
        $object = SQLService::destroyRecord($args['id'], Comment::class);

        return $object;
    }
}

class ActionCommentMutation extends CommentMutation
{
    protected $attributes = [
        'name' => 'actionComment',
        'description' => 'Actions on review'
    ];

    public function args()
    {
        return [
            'object' => [
                'name' => 'object',
                'type' => Type::nonNull(GraphQL::type('ReviewCommentInput'))
            ],
            'action_id' => [
                'name' => 'action_id',
                'type' => Type::nonNull(Type::int())
            ]
        ];
    }

    public function resolve($root, $args)
    {
        CommentService::action($args['object'], $args['action_id']);
    }
}
