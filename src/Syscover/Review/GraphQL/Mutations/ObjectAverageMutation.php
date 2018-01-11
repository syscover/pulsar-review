<?php namespace Syscover\Review\GraphQL\Mutations;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use Syscover\Review\Models\ObjectAverage;
use Syscover\Review\Services\ObjectAverageService;
use Syscover\Core\Services\SQLService;

class ObjectAverageMutation extends Mutation
{
    public function type()
    {
        return GraphQL::type('ReviewObjectAverage');
    }
}

class AddObjectAverageMutation extends ObjectAverageMutation
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
                'type' => Type::nonNull(GraphQL::type('ReviewObjectAverageInput'))
            ]
        ];
    }

    public function resolve($root, $args)
    {
        return ObjectAverageService::create($args['object']);
    }
}

class UpdateObjectAverageMutation extends ObjectAverageMutation
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
                'type' => Type::nonNull(GraphQL::type('ReviewObjectAverageInput'))
            ]
        ];
    }

    public function resolve($root, $args)
    {
        return ObjectAverageService::update($args['object']);
    }
}

class DeleteObjectAverageMutation extends ObjectAverageMutation
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
        $object = SQLService::destroyRecord($args['id'], ObjectAverage::class);

        return $object;
    }
}
