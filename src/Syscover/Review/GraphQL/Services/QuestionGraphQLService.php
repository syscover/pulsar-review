<?php namespace Syscover\Review\GraphQL\Services;

use Syscover\Core\GraphQL\Services\CoreGraphQLService;
use Syscover\Core\Services\SQLService;
use Syscover\Review\Models\Question;
use Syscover\Review\Models\QuestionAverage;
use Syscover\Review\Services\QuestionAverageService;
use Syscover\Review\Services\QuestionService;

class QuestionGraphQLService extends CoreGraphQLService
{
    protected $modelClassName = Question::class;
    protected $serviceClassName = QuestionService::class;

    public function update($root, array $args)
    {
        if(isset($args['object']['average']))
            QuestionAverageService::update($args['object']['average']);

        return $this->service->update($args['object']);
    }

    public function delete($root, array $args)
    {
        $object = SQLService::deleteRecord($args['id'], $this->modelClassName, $args['lang_id']);

        if($args['lang_id'] === base_lang())
            QuestionAverage::where('question_id', $args['id'])->delete();

        return $object;
    }
}