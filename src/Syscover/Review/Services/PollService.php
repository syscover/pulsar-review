<?php namespace Syscover\Review\Services;

use Syscover\Review\Models\Poll;

class PollService
{
    public static function create($object)
    {
        $object = PollService::checkCreate($object);
        return Poll::create(PollService::builder($object));
    }

    public static function update($object)
    {
        $object = PollService::checkUpdate($object);
        Poll::where('id', $object['id'])->update(PollService::builder($object));

        return Poll::find($object['id']);
    }

    private static function builder($object)
    {
        $object = collect($object);
        return $object->only(['name', 'send_notification', 'validate', 'default_high_score', 'mailing_days', 'expiration_days', 'review_route', 'comment_route', 'review_email_template', 'comment_email_template'])->toArray();
    }

    private static function checkCreate($object)
    {
        if(empty($object['name'])) throw new \Exception('You have to define a name field to create a poll');

        // delete index, this values has default values
        if($object['default_high_score'] === null)  unset($object['default_high_score']);
        if($object['mailing_days'] === null)        unset($object['mailing_days']);
        if($object['expiration_days'] === null)     unset($object['expiration_days']);

        return $object;
    }

    private static function checkUpdate($object)
    {
        if(empty($object['id'])) throw new \Exception('You have to define a id field to update a poll');

        // delete index, this values has default values
        if($object['default_high_score'] === null)  unset($object['default_high_score']);
        if($object['mailing_days'] === null)        unset($object['mailing_days']);
        if($object['expiration_days'] === null)     unset($object['expiration_days']);

        return $object;
    }
}