<?php namespace Syscover\Review\Services;

use Syscover\Review\Models\ObjectAverage;
use Syscover\Review\Models\Review;

class ObjectAverageService
{
    public static function create($object)
    {
        ObjectAverageService::checkCreate($object);
        return ObjectAverage::create(ObjectAverageService::builder($object));
    }

    public static function update($object)
    {
        ObjectAverageService::checkUpdate($object);
        ObjectAverage::where('id', $object['id'])->update(ObjectAverageService::builder($object));

        return ObjectAverage::find($object['id']);
    }

    private static function builder($object)
    {
        $object = collect($object);
        return $object->only(['poll_id', 'object_id', 'object_type', 'object_name', 'reviews', 'total', 'average'])->toArray();
    }

    private static function checkCreate($object)
    {
        if(empty($object['poll_id']))       throw new \Exception('You have to define a poll_id field to create a object average');
        if(empty($object['object_id']))     throw new \Exception('You have to define a object_id field to create a object average');
        if(empty($object['object_type']))   throw new \Exception('You have to define a object_type field to create a object average');
        if(empty($object['object_name']))   throw new \Exception('You have to define a object_name field to create a object average');
    }

    private static function checkUpdate($object)
    {
        if(empty($object['id'])) throw new \Exception('You have to define a id field to update a object average');
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