<?php namespace Syscover\Review\Services;

use Syscover\Review\Models\Poll;

class PollService
{
    /**
     * @param array     $object     contain properties of poll
     * @return \Syscover\Review\Models\Poll
     */
    public static function create($object)
    {
        if($object['default_high_score'] === null) unset($object['default_high_score']);
        if($object['mailing_days'] === null) unset($object['mailing_days']);
        if($object['expiration_days'] === null) unset($object['expiration_days']);

        return Poll::create($object);
    }

    /**
     * @param array     $object     contain properties of poll
     * @return \Syscover\Review\Models\Poll
     */
    public static function update($object)
    {
        $object = collect($object);

        Poll::where('id', $object->get('id'))->update([
            'name'                  => $object->get('name'),
            'email_template'        => $object->get('email_template'),
            'send_notification'     => $object->get('send_notification'),
            'poll_route'            => $object->get('poll_route'),
            'validate'              => $object->get('validate'),
            'default_high_score'    => $object->get('default_high_score', 5),
            'mailing_days'          => $object->get('mailing_days', 0),
            'expiration_days'       => $object->get('expiration_days', 30)
        ]);

        return Poll::find($object->get('id'));
    }
}