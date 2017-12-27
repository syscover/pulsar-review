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
     * Add or create average
     *
     * @param   \Syscover\Review\Models\Review $review
     * @return \Syscover\Review\Models\QuestionAverage
     */
    public static function addAverage(Review $review)
    {
        foreach ($review->responses as $response)
        {
            $question   = $response->questions->first();
            $average    = $question->average;

            if($question->type_id === 1)
            {
                $average->reviews   = $average->reviews + 1;
                $average->total     = $average->total + $response->score;
                $average->average   = $average->reviews === 0? 0 : $average->total / $average->reviews;
                $average->save();
            }
        }

        return $average;
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

            if($question->type_id === 1)
            {
                $average->reviews   = $average->reviews - 1;
                $average->total     = $average->total - $response->score;
                $average->average   = $average->reviews === 0? 0 : $average->total / $average->reviews;
                $average->save();
            }
        }

        return $average;
    }
}