<?php namespace Syscover\Review\GraphQL\Mutations;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use Syscover\Review\Models\Average;
use Syscover\Review\Services\AverageService;
use Syscover\Core\Services\SQLService;

class AverageMutation extends Mutation
{
    public function type()
    {
        return GraphQL::type('ReviewAverage');
    }
}

class AddAverageMutation extends AverageMutation
{
    protected $attributes = [
        'name' => 'addAverage',
        'description' => 'Add new average'
    ];

    public function args()
    {
        return [
            'object' => [
                'name' => 'object',
                'type' => Type::nonNull(GraphQL::type('ReviewAverageInput'))
            ]
        ];
    }

    public function resolve($root, $args)
    {
        return AverageService::create($args['object']);
    }
}

class UpdateAverageMutation extends AverageMutation
{
    protected $attributes = [
        'name' => 'updateAverage',
        'description' => 'Update average'
    ];

    public function args()
    {
        return [
            'object' => [
                'name' => 'object',
                'type' => Type::nonNull(GraphQL::type('ReviewAverageInput'))
            ]
        ];
    }

    public function resolve($root, $args)
    {
        return AverageService::update($args['object']);
    }
}

class DeleteAverageMutation extends AverageMutation
{
    protected $attributes = [
        'name' => 'deleteAverage',
        'description' => 'Delete average'
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
        $object = SQLService::destroyRecord($args['id'], Average::class);

        return $object;
    }
}

class ActionAverageMutation extends AverageMutation
{
    protected $attributes = [
        'name' => 'actionAverage',
        'description' => 'Actions on average'
    ];

    public function args()
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::nonNull(Type::int())
            ],
            'action_id' => [
                'name' => 'action_id',
                'type' => Type::nonNull(Type::int())
            ]
        ];
    }

    public function resolve($root, $args)
    {
        $average = Average::find($args['id']);

        // 1 - Validate and add score
        // 2 - Invalidate and subtract score
        switch ($args['action_id'])
        {
            case 1:
                AverageService::addAverage($average);
                break;
            case 2:
                AverageService::removeAverage($average);
                break;
        }
    }
}
