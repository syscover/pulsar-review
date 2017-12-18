<?php namespace Syscover\Review\Services;

use Syscover\Review\Models\Average;
use Syscover\Review\Models\Review;

class AverageService
{
    /**
     * @param array     $object     contain properties of poll
     * @return \Syscover\Review\Models\Review
     */
    public static function create($object)
    {
//        if($object['default_high_score'] === null) unset($object['default_high_score']);
//        if($object['mailing_days'] === null) unset($object['mailing_days']);
//        if($object['expiration_days'] === null) unset($object['expiration_days']);

        //return Average::create($object);
    }

    /**
     * @param array     $object     contain properties of poll
     * @return \Syscover\Review\Models\Review
     */
    public static function update($object)
    {
        $object = collect($object);

        Average::where('id', $object->get('id'))->update(
            $object->only((new Average())->getFillable())->toArray()
        );

        return Average::find($object->get('id'));
    }

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