<?php namespace Syscover\Review\GraphQL;

use GraphQL;

class ReviewGraphQLServiceProvider
{
    public static function bootGraphQLTypes()
    {
        // POLL
        GraphQL::addType(\Syscover\Review\GraphQL\Types\PollType::class, 'ReviewPoll');
        GraphQL::addType(\Syscover\Review\GraphQL\Inputs\PollInput::class, 'ReviewPollInput');
    }

    public static function bootGraphQLSchema()
    {
        GraphQL::addSchema('default', array_merge_recursive(GraphQL::getSchemas()['default'], [
            'query' => [
                // POLL
                'reviewPollsPagination'            => \Syscover\Review\GraphQL\Queries\PollsPaginationQuery::class,
                'reviewPolls'                      => \Syscover\Review\GraphQL\Queries\PollsQuery::class,
                'reviewPoll'                       => \Syscover\Review\GraphQL\Queries\PollQuery::class,
            ],
            'mutation' => [
                // POLL
                'reviewAddPoll'                     => \Syscover\Review\GraphQL\Mutations\AddPollMutation::class,
                'reviewUpdatePoll'                  => \Syscover\Review\GraphQL\Mutations\UpdatePollMutation::class,
                'reviewDeletePoll'                  => \Syscover\Review\GraphQL\Mutations\DeletePollMutation::class,
            ]
        ]));
    }
}