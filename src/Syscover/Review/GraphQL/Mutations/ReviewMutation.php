<?php namespace Syscover\Review\GraphQL\Mutations;

use Illuminate\Support\Facades\Notification;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use Syscover\Review\Models\Response;
use Syscover\Review\Models\Review;
use Syscover\Review\Services\ObjectAverageService;
use Syscover\Review\Services\QuestionAverageService;
use Syscover\Review\Services\ReviewService;
use Syscover\Core\Services\SQLService;
use Syscover\Review\Notifications\ReviewOwnerObject as ReviewOwnerObjectNotification;

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
            'object' => [
                'name' => 'object',
                'type' => Type::nonNull(GraphQL::type('ReviewReviewInput'))
            ],
            'action_id' => [
                'name' => 'action_id',
                'type' => Type::nonNull(Type::int())
            ]
        ];
    }

    public function resolve($root, $args)
    {
        $review         = Review::find($args['object']['id']);
        $questions      = $review->poll->questions;
        $scoreQuestions = 0;

        if(is_array($args['object']['responses']) && count($args['object']['responses']) > 0)
        {
            // if review is validated, remove you score from average, before add new score
            if($args['action_id'] === 1 && $review->validated)
            {
                ObjectAverageService::removeAverageInvalidate($review);
                QuestionAverageService::removeAverage($review);
            }

            // if review is not validated and will be validated and we must send notification to owner
            if($args['action_id'] === 1 && ! $review->validated && $review->poll->send_notification)
            {
                // send email notification to owner object
                Notification::route('mail', $review->object_email)
                    ->notify(new ReviewOwnerObjectNotification($review));
            }

            $responses = collect($args['object']['responses']);

            foreach ($responses as $response)
            {
                $response = collect($response);

                Response::where('id', $response->get('id'))->update([
                    'score'     => $response->get('score'),
                    'text'      => $response->get('text')
                ]);

                if($questions->where('id', $response->get('question_id'))->first()->type_id === 1)
                {
                    $scoreQuestions++;
                }
            }

            $totalScore         = $responses->sum('score');
            $review->average    = $totalScore /  $scoreQuestions;
            $review->save();
        }

        // 1 - Validate and add score
        // 2 - Invalidate and subtract score
        // 3 - Only update review
        switch ($args['action_id'])
        {
            case 1:
                ObjectAverageService::addAverageValidate($review);
                QuestionAverageService::addAverage($review);
                break;
            case 2:
                ObjectAverageService::removeAverageInvalidate($review);
                QuestionAverageService::removeAverage($review);
                break;
            case 3:
                break;
        }
    }
}
