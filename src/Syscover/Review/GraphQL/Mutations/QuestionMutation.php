<?php namespace Syscover\Review\GraphQL\Mutations;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use Syscover\Review\Models\QuestionAverage;
use Syscover\Review\Services\QuestionAverageService;
use Syscover\Review\Services\QuestionService;

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
        if(isset($args['object']['average']))
            QuestionAverageService::update($args['object']['average']);

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
            'lang_id' => [
                'name' => 'lang_id',
                'type' => Type::nonNull(Type::string())
            ],
            'id' => [
                'name' => 'id',
                'type' => Type::nonNull(Type::int())
            ]
        ];
    }

    public function resolve($root, $args)
    {
        $object = QuestionService::delete($args['id'], $args['lang_id']);

        if($args['lang_id'] === base_lang())
        {
            QuestionAverage::where('question_id', $args['id'])->delete();
        }

        return $object;
    }
}
