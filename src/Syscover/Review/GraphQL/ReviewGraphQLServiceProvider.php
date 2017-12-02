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

    }
}