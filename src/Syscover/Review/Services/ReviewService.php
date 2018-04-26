<?php namespace Syscover\Review\Services;

use Syscover\Review\Models\Review;

class ReviewService
{
    public static function create($object)
    {
        ReviewService::checkCreate($object);
        return Review::create(ReviewService::builder($object));
    }

    public static function update($object)
    {
        ReviewService::checkUpdate($object);
        Review::where('id', $object['id'])->update(ReviewService::builder($object));

        return Review::find($object['id']);
    }

    public static function action($object)
    {

    }

    private static function builder($object)
    {
        $object = collect($object);
        return $object->only('date', 'poll_id', 'object_id', 'object_type', 'object_name', 'object_email', 'customer_id', 'customer_name', 'customer_email', 'customer_verified', 'email_template', 'email_subject', 'poll_url', 'completed', 'validated', 'mailing', 'sent', 'expiration')->toArray();
    }

    private static function checkCreate($object)
    {
        if(empty($object['poll_id']))           throw new \Exception('You have to define a poll_id field to create a review');
        if(empty($object['object_id']))         throw new \Exception('You have to define a object_id field to create a review');
        if(empty($object['object_type']))       throw new \Exception('You have to define a object_type field to create a review');
        if(empty($object['object_name']))       throw new \Exception('You have to define a object_name field to create a review');
        if(empty($object['customer_name']))     throw new \Exception('You have to define a customer_name field to create a review');
        if(empty($object['customer_email']))    throw new \Exception('You have to define a customer_email field to create a review');
    }

    private static function checkUpdate($object)
    {
        if(empty($object['id'])) throw new \Exception('You have to define a id field to update a review');
    }
}