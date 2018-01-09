<?php namespace Syscover\Review\GraphQL\Mutations;

use Illuminate\Support\Facades\Mail;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use Syscover\Review\Models\Comment;
use Syscover\Review\Services\CommentService;
use Syscover\Core\Services\SQLService;
use Syscover\Review\Mails\MemberHasComment as MailComment;


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
        $comment        = Comment::find($args['object']['id']);
        $comment->text  = $args['object']['text'];

        // 1 - Update, validate comment and send email
        // 2 - Update, validate comment
        // 3 - Update, invalidate comment
        switch ($args['action_id'])
        {
            case 1:
                $comment->validated = true;
                $comment->save();

                Mail::to($comment->owner_id === 1 ? $comment->review->customer_email : $comment->review->object_email)
                    ->send(new MailComment(
                        'Ruralka: Tienes un comentario de ' . $comment->name,
                        'review::mails.content.member_has_comment',
                        //$review->email_template ? $review->email_template : 'review::mails.content.review',
                        $comment
                    ));
                break;
            case 2:
                $comment->validated = true;
                $comment->save();
                break;
            case 3:
                $comment->validated = false;
                $comment->save();
                break;
        }
    }
}
