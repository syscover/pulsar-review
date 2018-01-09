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
        if($object['default_high_score'] === null) unset($object['default_high_score']);
        if($object['mailing_days'] === null) unset($object['mailing_days']);
        if($object['expiration_days'] === null) unset($object['expiration_days']);

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
            'name'                  => $object->get('name'),
            'email_template'        => $object->get('email_template'),
            'send_notification'     => $object->get('send_notification'),
            'poll_url'              => $object->get('poll_url'),
            'validate'              => $object->get('validate'),
            'default_high_score'    => $object->get('default_high_score', 5),
            'mailing_days'          => $object->get('mailing_days', 0),
            'expiration_days'       => $object->get('expiration_days', 30)
        ]);

        return Review::find($object->get('id'));
    }
}