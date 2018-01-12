<?php namespace Syscover\Review\Services;

use Syscover\Review\Models\QuestionAverage;
use Syscover\Review\Models\Review;

class QuestionAverageService
{
    /**
     * @param array     $object     contain properties of questionAverage
     * @return \Syscover\Review\Models\QuestionAverage
     */
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
            $question   = $response->questions->first();
            $average    = $question->average;

            // 1 - score
            // 2 - text
            // 3 - boolean (inactivated)
            // 4 - select (inactivated)
            if($question->type_id === 1)
            {
                $average->reviews   = $average->reviews + 1;
                $average->total     = $average->total + $response->score;
                $average->average   = $average->reviews === 0 ? 0 : $average->total / $average->reviews;
                $average->save();
            }
        }
    }

    /**
     * Remove average
     *
     * @param \Syscover\Review\Models\Review $review
     * @return \Syscover\Review\Models\QuestionAverage
     */
    public static function removeAverage(Review $review)
    {
        foreach ($review->responses as $response)
        {
            $question   = $response->questions->first();
            $average    = $question->average;

            // 1 - score
            // 2 - text
            // 3 - boolean (inactivated)
            // 4 - select (inactivated)
            if($question->type_id === 1)
            {
                $average->reviews   = $average->reviews - 1;
                $average->total     = $average->total - $response->score;
                $average->average   = $average->reviews === 0 ? 0 : $average->total / $average->reviews;
                $average->save();
            }
        }

        return $average;
    }
}