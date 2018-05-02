<?php namespace Syscover\Review\Services;

use Syscover\Review\Models\ObjectQuestionAverage;
use Syscover\Review\Models\QuestionAverage;
use Syscover\Review\Models\Review;

class QuestionAverageService
{
    public static function create($object)
    {
        return QuestionAverage::create($object);
    }

    /**
     * @param array     $object     contain properties of questionAverage
     * @return \Syscover\Review\Models\QuestionAverage
     */
    public static function update($object)
    {
        $object = collect($object);

        QuestionAverage::where('id', $object->get('id'))
            ->update([
                'reviews'   => $object->get('reviews'),
                'total'     => $object->get('total'),
                'average'   => $object->get('average')
            ]);

        return QuestionAverage::find($object->get('id'));
    }

    /**
     * Add or create average
     *
     * @param   \Syscover\Review\Models\Review $review
     */
    public static function addAverage(Review $review)
    {
        foreach ($review->responses as $response)
        {
            $question = $response->questions->first();

            // 1 - score
            // 2 - text
            // 3 - boolean (inactivated)
            // 4 - select (inactivated)
            if($question->type_id === 1)
            {
                // add question average
                $averageQuestion            = $question->average;
                $averageQuestion->reviews   = $averageQuestion->reviews + 1;
                $averageQuestion->total     = $averageQuestion->total + $response->score;
                $averageQuestion->average   = $averageQuestion->reviews === 0 ? 0 : $averageQuestion->total / $averageQuestion->reviews;
                $averageQuestion->save();

                // add object question average
                $objectAverageQuestion = ObjectQuestionAverage::firstOrCreate([
                        'poll_id'       => $review->poll_id,
                        'question_id'   => $question->id,
                        'object_id'     => $review->object_id,
                        'object_type'   => $review->object_type
                    ]);

                $objectAverageQuestion->reviews   = $objectAverageQuestion->reviews + 1;
                $objectAverageQuestion->total     = $objectAverageQuestion->total + $response->score;
                $objectAverageQuestion->average   = $objectAverageQuestion->reviews === 0 ? 0 : $objectAverageQuestion->total / $objectAverageQuestion->reviews;
                $objectAverageQuestion->save();
            }
        }
    }

    /**
     * Remove average
     *
     * @param \Syscover\Review\Models\Review $review
     */
    public static function removeAverage(Review $review)
    {
        foreach ($review->responses as $response)
        {
            $question = $response->questions->first();

            // 1 - score
            // 2 - text
            // 3 - boolean (inactivated)
            // 4 - select (inactivated)
            if($question->type_id === 1)
            {
                // remove question average
                $average            = $question->average;
                $average->reviews   = $average->reviews - 1;
                $average->total     = $average->total - $response->score;
                $average->average   = $average->reviews === 0 ? 0 : $average->total / $average->reviews;
                $average->save();

                // remove object question average
                $objectAverageQuestion = ObjectQuestionAverage::where('poll_id', $review->poll_id)
                    ->where('question_id', $question->id)
                    ->where('object_id', $review->object_id)
                    ->where('object_type', $review->object_type)
                    ->first();

                $objectAverageQuestion->reviews   = $objectAverageQuestion->reviews - 1;
                $objectAverageQuestion->total     = $objectAverageQuestion->total - $response->score;
                $objectAverageQuestion->average   = $objectAverageQuestion->reviews === 0 ? 0 : $objectAverageQuestion->total / $objectAverageQuestion->reviews;
                $objectAverageQuestion->save();
            }
        }
    }
}