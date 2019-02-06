<?php namespace Syscover\Review\Services;

use Syscover\Review\Models\ObjectQuestionAverage;

class ObjectQuestionAverageService
{
    public static function create($object)
    {
        self::checkCreate($object);
        return ObjectQuestionAverage::create(self::builder($object));
    }

    public static function update($object)
    {
        self::checkUpdate($object);
        ObjectQuestionAverage::where('id', $object['id'])->update(self::builder($object));

        return ObjectQuestionAverage::find($object['id']);
    }

    private static function builder($object)
    {
        $object = collect($object);
        return $object->only([
            'poll_id',
            'question_id',
            'object_id',
            'object_type',
            'reviews',
            'total',
            'average',
            'fake_average'
        ])->toArray();
    }

    private static function checkCreate($object)
    {
        if(empty($object['poll_id']))       throw new \Exception('You have to define a poll_id field to create a question object average');
        if(empty($object['object_id']))     throw new \Exception('You have to define a object_id field to create a question object average');
        if(empty($object['object_type']))   throw new \Exception('You have to define a object_type field to create a question object average');
    }

    private static function checkUpdate($object)
    {
        if(empty($object['id'])) throw new \Exception('You have to define a id field to update a object average');
    }
}
