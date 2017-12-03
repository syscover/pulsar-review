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
            'default_score'         => $object->get('default_score', 5),
            'mailing_days'          => $object->get('mailing_days', 0),
            'expiration_days'       => $object->get('expiration_days', 30)
        ]);

        return Poll::find($object->get('id'));
    }
}