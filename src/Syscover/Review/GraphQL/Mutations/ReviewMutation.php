<?php namespace Syscover\Review\GraphQL\Mutations;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use Syscover\Review\Models\Review;
use Syscover\Review\Services\AverageService;
use Syscover\Review\Services\ReviewService;
use Syscover\Core\Services\SQLService;

class ReviewMutation extends Mutation
{
    public function type()
    {
        return GraphQL::type('ReviewReview');
    }
}

class AddReviewMutation extends ReviewMutation
{
    protected $attributes = [
        'name' => 'addReview',
        'description' => 'Add new review'
    ];

    public function args()
    {
        return [
            'object' => [
                'name' => 'object',
                'type' => Type::nonNull(GraphQL::type('ReviewReviewInput'))
            ]
        ];
    }

    public function resolve($root, $args)
    {
        return ReviewService::create($args['object']);
    }
}

class UpdateReviewMutation extends ReviewMutation
{
    protected $attributes = [
        'name' => 'updateReview',
        'description' => 'Update review'
    ];

    public function args()
    {
        return [
            'object' => [
                'name' => 'object',
                'type' => Type::nonNull(GraphQL::type('ReviewReviewInput'))
            ]
        ];
    }

    public function resolve($root, $args)
    {
        return ReviewService::update($args['object']);
    }
}

class DeleteReviewMutation extends ReviewMutation
{
    protected $attributes = [
        'name' => 'deleteReview',
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
        $object = SQLService::destroyRecord($args['id'], Review::class);

        return $object;
    }
}

class ActionReviewMutation extends ReviewMutation
{
    protected $attributes = [
        'name' => 'actionReview',
        'description' => 'Actions on review'
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
        $review = Review::find($args['id']);

        // 1 - Validate and add score
        // 2 - Invalidate and subtract score
        switch ($args['action_id'])
        {
            case 1:
                AverageService::addAverage($review);
                break;
            case 2:
                AverageService::removeAverage($review);
                break;
        }
    }
}
