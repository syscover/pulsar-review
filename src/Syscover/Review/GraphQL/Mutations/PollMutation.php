<?php namespace Syscover\Review\GraphQL\Mutations;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use Syscover\Review\Models\Poll;
use Syscover\Review\Services\PollService;
use Syscover\Core\Services\SQLService;

class PollMutation extends Mutation
{
    public function type()
    {
        return GraphQL::type('ReviewPoll');
    }
}

class AddPollMutation extends PollMutation
{
    protected $attributes = [
        'name' => 'addPoll',
        'description' => 'Add new poll'
    ];

    public function args()
    {
        return [
            'object' => [
                'name' => 'object',
                'type' => Type::nonNull(GraphQL::type('ReviewPollInput'))
            ]
        ];
    }

    public function resolve($root, $args)
    {
        return PollService::create($args['object']);
    }
}

class UpdatePollMutation extends PollMutation
{
    protected $attributes = [
        'name' => 'updatePoll',
        'description' => 'Update poll'
    ];

    public function args()
    {
        return [
            'object' => [
                'name' => 'object',
                'type' => Type::nonNull(GraphQL::type('ReviewPollInput'))
            ]
        ];
    }

    public function resolve($root, $args)
    {
        return PollService::update($args['object']);
    }
}

class DeletePollMutation extends PollMutation
{
    protected $attributes = [
        'name' => 'deletePoll',
        'description' => 'Delete poll'
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
        $object = SQLService::deleteRecord($args['id'], Poll::class);

        return $object;
    }
}
