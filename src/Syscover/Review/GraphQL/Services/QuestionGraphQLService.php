<?php namespace Syscover\Review\GraphQL\Services;

use Syscover\Core\GraphQL\Services\CoreGraphQLService;
use Syscover\Core\Services\SQLService;
use Syscover\Review\Models\Question;
use Syscover\Review\Models\QuestionAverage;
use Syscover\Review\Services\QuestionAverageService;
use Syscover\Review\Services\QuestionService;

class QuestionGraphQLService extends CoreGraphQLService
{
    public function __construct(Question $model, QuestionService $service)
    {
        $this->model = $model;
        $this->service = $service;
    }

    public function update($root, array $args)
    {
        if(isset($args['payload']['average']))
            QuestionAverageService::update($args['payload']['average']);

        return $this->service->update($args['payload']);
    }

    public function delete($root, array $args)
    {
        $object = SQLService::deleteRecord($args['id'], get_class($this->model), $args['lang_id']);

        if($args['lang_id'] === base_lang())
            QuestionAverage::where('question_id', $args['id'])->delete();

        return $object;
    }
}
