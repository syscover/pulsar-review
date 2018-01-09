<?php namespace Syscover\Review\Services;

use Syscover\Review\Models\Review;

class ReviewService
{
    /**
     * @param array     $object     contain properties of poll
     * @return \Syscover\Review\Models\Review
     */
    public static function create($object)
    {
        return Review::create($object);
    }

    /**
     * @param array     $object     contain properties of poll
     * @return \Syscover\Review\Models\Review
     */
    public static function update($object)
    {
        $object = collect($object);

        Review::where('id', $object->get('id'))->update([
            'customer_name'         => $object->get('customer_name'),
            'poll_url'              => $object->get('poll_url')
        ]);

        return Review::find($object->get('id'));
    }
}