<?php namespace Syscover\Review\Services;

use Syscover\Review\Models\Average;
use Syscover\Review\Models\Review;

class AverageService
{
    /**
     * Add or create average
     *
     * @param \Syscover\Review\Models\Review $review
     * @return \Syscover\Review\Models\Average
     */
    public static function addAverage(Review $review)
    {
        $average = Average::where('poll_id', $review->poll_id)
            ->where('object_id', $review->object_id)
            ->where('object_type', $review->object_type)
            ->first();

        if(! $review->validated)
        {
            if($average)
            {
                $average->reviews   = $average->reviews + 1;
                $average->total     = $average->total + $review->average;
                $average->average   = $average->total / $average->reviews;
                $average->save();
            }
            else
            {
                $average = Average::create([
                    'poll_id'       => $review->poll_id,
                    'object_id'     => $review->object_id,
                    'object_type'   => $review->object_type,
                    'object_name'   => $review->object_name,
                    'reviews'       => 1,
                    'total'         => $review->average,
                    'average'       => $review->average
                ]);
            }

            $review->validated = true;
            $review->save();
        }

        return $average;
    }

    /**
     * Remove average
     *
     * @param \Syscover\Review\Models\Review $review
     * @return \Syscover\Review\Models\Average
     */
    public static function removeAverage(Review $review)
    {
        $average = Average::where('poll_id', $review->poll_id)
            ->where('object_id', $review->object_id)
            ->where('object_type', $review->object_type)
            ->first();

        if($review->validated)
        {
            if ($average)
            {
                $average->reviews = $average->reviews - 1;
                $average->total = $average->total - $review->average;
                $average->average = $average->reviews === 0? 0 : $average->total / $average->reviews;
                $average->save();
            }

            $review->validated = false;
            $review->save();
        }

        return $average;
    }
}