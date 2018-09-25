<?php namespace Syscover\Review\GraphQL\Services;

use Syscover\Core\GraphQL\Services\CoreGraphQLService;
use Syscover\Review\Models\Question;
use Syscover\Review\Services\QuestionService;

class QuestionGraphQLService extends CoreGraphQLService
{
    protected $model = Question::class;
    protected $service = QuestionService::class;
}