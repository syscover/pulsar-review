<?php namespace Syscover\Review\Services;

use Syscover\Review\Models\Poll;

class PollService
{
    public static function create($object)
    {
        return Poll::create(PollService::builder(
            PollService::check($object)
        ));
    }

    public static function update($object)
    {
        Poll::where('id', $object['id'])->update(PollService::builder(
            PollService::check($object)
        ));

        return Poll::find($object['id']);
    }

    private static function builder($object)
    {
        $object = collect($object);
        $data = [];

        if($object->has('name'))                $data['name'] = $object->get('name');
        if($object->has('email_template'))      $data['email_template'] = $object->get('email_template');
        if($object->has('poll_route'))          $data['poll_route'] = $object->get('poll_route');
        if($object->has('send_notification'))   $data['send_notification'] = $object->get('send_notification');
        if($object->has('validate'))            $data['validate'] = $object->get('validate');
        if($object->has('default_high_score'))  $data['default_high_score'] = $object->get('default_high_score');
        if($object->has('mailing_days'))        $data['mailing_days'] = $object->get('mailing_days');
        if($object->has('expiration_days'))     $data['expiration_days'] = $object->get('expiration_days');

        return $data;
    }

    private static function check($object)
    {
        if(empty($object['name'])) throw new \Exception('You have to define a name field to create a poll');

        // delete index, this values has default values
        if($object['default_high_score'] === null)  unset($object['default_high_score']);
        if($object['mailing_days'] === null)        unset($object['mailing_days']);
        if($object['expiration_days'] === null)     unset($object['expiration_days']);

        return $object;
    }
}