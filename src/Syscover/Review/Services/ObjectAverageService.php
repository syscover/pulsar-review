<?php namespace Syscover\Review\Services;

use Syscover\Review\Models\ObjectAverage;
use Syscover\Review\Models\Review;

class ObjectAverageService
{
    /**
     * @param array     $object     contain properties of objectAverage
     * @return \Syscover\Review\Models\ObjectAverage
     */
    public static function create($object)
    {
        return ObjectAverage::create($object);
    }

    /**
     * @param array     $object     contain properties of objectAverage
     * @return \Syscover\Review\Models\ObjectAverage
     */
    public static function update($object)
    {
        $object = collect($object);

        ObjectAverage::where('id', $object->get('id'))->update(
            $object->only((new ObjectAverage())->getFillable())->toArray()
        );

        return ObjectAverage::find($object->get('id'));
    }

    /**
     * Add or create average and validate review
     *
     * @param \Syscover\Review\Models\Review $review
     * @return \Syscover\Review\Models\ObjectAverage
     */
    public static function addAverageValidate(Review $review)
    {
        $average = ObjectAverage::where('poll_id', $review->poll_id)
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
                $average = ObjectAverageService::create([
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
     * @return \Syscover\Review\Models\ObjectAverage
     */
    public static function removeAverageInvalidate(Review $review)
    {
        $average = ObjectAverage::where('poll_id', $review->poll_id)
            ->where('object_id', $review->object_id)
            ->where('object_type', $review->object_type)
            ->first();

        if($review->validated)
        {
            if ($average)
            {
                $average->reviews   = $average->reviews - 1;
                $average->total     = $average->total - $review->average;
                $average->average   = $average->reviews === 0 ? 0 : $average->total / $average->reviews;
                $average->save();
            }

            $review->validated = false;
            $review->save();
        }

        return $average;
    }
}