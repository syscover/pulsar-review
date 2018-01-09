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
            'email_template'        => $object->get('email_template'),
            'object_name'           => $object->get('object_name'),
            'object_email'          => $object->get('object_email'),
            'customer_name'         => $object->get('customer_name'),
            'customer_email'        => $object->get('customer_email'),
            'email_subject'         => $object->get('email_subject'),
            'poll_url'              => $object->get('poll_url')
        ]);

        return Review::find($object->get('id'));
    }
}