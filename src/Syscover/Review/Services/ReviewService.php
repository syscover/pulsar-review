<?php namespace Syscover\Review\Services;

use Illuminate\Support\Facades\Notification;
use Syscover\Review\Models\Review;
use Syscover\Review\Models\Response;
use Syscover\Review\Notifications\ReviewOwnerObject as ReviewOwnerObjectNotification;

class ReviewService
{
    public static function create($object)
    {
        self::checkCreate($object);
        return Review::create(self::builder($object));
    }

    public static function update($object)
    {
        self::checkUpdate($object);
        Review::where('id', $object['id'])->update(self::builder($object));

        return Review::find($object['id']);
    }

    private static function builder($object)
    {
        $object = collect($object);
        return $object->only(['date', 'poll_id', 'object_id', 'object_type', 'object_name', 'object_email', 'customer_id', 'customer_name', 'customer_email', 'customer_verified', 'email_template', 'email_subject', 'review_url', 'review_completed_url', 'completed', 'validated', 'mailing', 'sent', 'expiration'])->toArray();
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

    public static function action($object, $actionId)
    {
        $review = Review::find($object['id']);

        if(is_array($object['responses']) && count($object['responses']) > 0)
        {
            // if review is validated, remove you score from average, before add new score
            if($actionId === 1 && $review->validated)
            {
                ObjectAverageService::removeAverageInvalidate($review);
                QuestionAverageService::removeAverage($review);
            }

            // if review is not validated and will be validated and we must send notification to owner
            if($actionId === 1 && ! $review->validated && $review->poll->send_notification)
            {
                // send email notification to owner object
                Notification::route('mail', $review->object_email)
                    ->notify(new ReviewOwnerObjectNotification($review));
            }

            $responses = collect($object['responses']);

            foreach ($responses as $response)
            {
                $response = collect($response);

                Response::where('id', $response->get('id'))->update([
                    'score' => $response->get('score'),
                    'text'  => $response->get('text')
                ]);
            }

            // reload new responses related
            $review->refresh();
        }

        // 1 - Validate and add score
        // 2 - Invalidate and subtract score
        // 3 - Only update review
        switch ($actionId)
        {
            case 1:
                ObjectAverageService::addAverageValidate($review);
                QuestionAverageService::addAverage($review);
                break;
            case 2:
                ObjectAverageService::removeAverageInvalidate($review);
                QuestionAverageService::removeAverage($review);
                break;
            case 3:
                break;
        }
    }
}