<?php namespace Syscover\Review\GraphQL;

use GraphQL;

class ReviewGraphQLServiceProvider
{
    public static function bootGraphQLTypes()
    {
        // POLL
        GraphQL::addType(\Syscover\Review\GraphQL\Types\PollType::class, 'ReviewPoll');
        GraphQL::addType(\Syscover\Review\GraphQL\Inputs\PollInput::class, 'ReviewPollInput');

        // QUESTION
        GraphQL::addType(\Syscover\Review\GraphQL\Types\QuestionType::class, 'ReviewQuestion');
        GraphQL::addType(\Syscover\Review\GraphQL\Inputs\QuestionInput::class, 'ReviewQuestionInput');

        // REVIEW
        GraphQL::addType(\Syscover\Review\GraphQL\Types\ReviewType::class, 'ReviewReview');
        GraphQL::addType(\Syscover\Review\GraphQL\Inputs\ReviewInput::class, 'ReviewReviewInput');

        // AVERAGE
        GraphQL::addType(\Syscover\Review\GraphQL\Types\AverageType::class, 'ReviewAverage');
        GraphQL::addType(\Syscover\Review\GraphQL\Inputs\AverageInput::class, 'ReviewAverageInput');
    }

    public static function bootGraphQLSchema()
    {
        GraphQL::addSchema('default', array_merge_recursive(GraphQL::getSchemas()['default'], [
            'query' => [
                // POLL
                'reviewPollsPagination'             => \Syscover\Review\GraphQL\Queries\PollsPaginationQuery::class,
                'reviewPolls'                       => \Syscover\Review\GraphQL\Queries\PollsQuery::class,
                'reviewPoll'                        => \Syscover\Review\GraphQL\Queries\PollQuery::class,

                // QUESTION
                'reviewQuestionsPagination'         => \Syscover\Review\GraphQL\Queries\QuestionsPaginationQuery::class,
                'reviewQuestions'                   => \Syscover\Review\GraphQL\Queries\QuestionsQuery::class,
                'reviewQuestion'                    => \Syscover\Review\GraphQL\Queries\QuestionQuery::class,

                // REVIEW
                'reviewReviewsPagination'           => \Syscover\Review\GraphQL\Queries\ReviewsPaginationQuery::class,
                'reviewReviews'                     => \Syscover\Review\GraphQL\Queries\ReviewsQuery::class,
                'reviewReview'                      => \Syscover\Review\GraphQL\Queries\ReviewQuery::class,

                // AVERAGE
                'reviewAveragesPagination'           => \Syscover\Review\GraphQL\Queries\AveragesPaginationQuery::class,
                'reviewAverages'                     => \Syscover\Review\GraphQL\Queries\AveragesQuery::class,
                'reviewAverage'                      => \Syscover\Review\GraphQL\Queries\AverageQuery::class,
            ],
            'mutation' => [
                // POLL
                'reviewAddPoll'                     => \Syscover\Review\GraphQL\Mutations\AddPollMutation::class,
                'reviewUpdatePoll'                  => \Syscover\Review\GraphQL\Mutations\UpdatePollMutation::class,
                'reviewDeletePoll'                  => \Syscover\Review\GraphQL\Mutations\DeletePollMutation::class,

                // QUESTION
                'reviewAddQuestion'                 => \Syscover\Review\GraphQL\Mutations\AddQuestionMutation::class,
                'reviewUpdateQuestion'              => \Syscover\Review\GraphQL\Mutations\UpdateQuestionMutation::class,
                'reviewDeleteQuestion'              => \Syscover\Review\GraphQL\Mutations\DeleteQuestionMutation::class,

                // REVIEW
                'reviewAddReview'                   => \Syscover\Review\GraphQL\Mutations\AddReviewMutation::class,
                'reviewUpdateReview'                => \Syscover\Review\GraphQL\Mutations\UpdateReviewMutation::class,
                'reviewDeleteReview'                => \Syscover\Review\GraphQL\Mutations\DeleteReviewMutation::class,
                'reviewActionReview'                => \Syscover\Review\GraphQL\Mutations\ActionReviewMutation::class,

                // AVERAGE
                'reviewAddAverage'                  => \Syscover\Review\GraphQL\Mutations\AddAverageMutation::class,
                'reviewUpdateAverage'               => \Syscover\Review\GraphQL\Mutations\UpdateAverageMutation::class,
                'reviewDeleteAverage'               => \Syscover\Review\GraphQL\Mutations\DeleteAverageMutation::class,
            ]
        ]));
    }
}