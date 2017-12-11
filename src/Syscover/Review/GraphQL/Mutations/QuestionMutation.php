<?php namespace Syscover\Review\GraphQL\Mutations;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use Syscover\Review\Models\Question;
use Syscover\Review\Services\QuestionService;
use Syscover\Core\Services\SQLService;

class QuestionMutation extends Mutation
{
    public function type()
    {
        return GraphQL::type('ReviewQuestion');
    }
}

class AddQuestionMutation extends QuestionMutation
{
    protected $attributes = [
        'name' => 'addQuestion',
        'description' => 'Add new question'
    ];

    public function args()
    {
        return [
            'object' => [
                'name' => 'object',
                'type' => Type::nonNull(GraphQL::type('ReviewQuestionInput'))
            ]
        ];
    }

    public function resolve($root, $args)
    {
        return QuestionService::create($args['object']);
    }
}

class UpdateQuestionMutation extends QuestionMutation
{
    protected $attributes = [
        'name' => 'updateQuestion',
        'description' => 'Update question'
    ];

    public function args()
    {
        return [
            'object' => [
                'name' => 'object',
                'type' => Type::nonNull(GraphQL::type('ReviewQuestionInput'))
            ]
        ];
    }

    public function resolve($root, $args)
    {
        return QuestionService::update($args['object']);
    }
}

class DeleteQuestionMutation extends QuestionMutation
{
    protected $attributes = [
        'name' => 'deleteQuestion',
        'description' => 'Delete question'
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
        $object = SQLService::destroyRecord($args['id'], Question::class);

        return $object;
    }
}
