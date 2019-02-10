<?php namespace Syscover\Review\GraphQL\Services;

use Syscover\Core\GraphQL\Services\CoreGraphQLService;
use Syscover\Review\Models\ObjectAverage;
use Syscover\Review\Services\ObjectAverageService;
use Syscover\Review\Services\ObjectQuestionAverageService;

class ObjectAverageGraphQLService extends CoreGraphQLService
{
    protected $model = ObjectAverage::class;
    protected $serviceClassName = ObjectAverageService::class;

    public function update($root, array $args)
    {
        $hasFake    = false;
        $total      = 0;
        $length     = count($args['payload']['question_averages']);

        foreach ($args['payload']['question_averages'] as $questionAverage)
        {
            ObjectQuestionAverageService::update($questionAverage);

            if (isset($questionAverage['fake_average']) && !empty($questionAverage['fake_average']))
            {
                $hasFake    = true;
                $total      += $questionAverage['fake_average'];
            }
            else
            {
                $total      += $questionAverage['average'];
            }
        }

        // add fake average
        $args['payload']['fake_average'] = $hasFake ? $total / $length : null;

        return $this->service->update($args['payload']);
    }
}
