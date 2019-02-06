<?php namespace Syscover\Review\GraphQL\Services;

use Syscover\Core\GraphQL\Services\CoreGraphQLService;
use Syscover\Review\Models\ObjectAverage;
use Syscover\Review\Models\ObjectQuestionAverage;
use Syscover\Review\Services\ObjectAverageService;
use Syscover\Review\Services\ObjectQuestionAverageService;

class ObjectAverageGraphQLService extends CoreGraphQLService
{
    protected $modelClassName = ObjectAverage::class;
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
        info($total);
        info($length);

        // add fake average
        if ($hasFake) $args['payload']['fake_average'] = $total / $length;

        return $this->service->update($args['payload']);
    }
}
