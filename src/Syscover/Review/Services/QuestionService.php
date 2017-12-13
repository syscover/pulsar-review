<?php namespace Syscover\Review\Services;

use Syscover\Review\Models\Question;

class QuestionService
{
    /**
     * @param array     $object     contain properties of question
     * @return \Syscover\Review\Models\Question
     */
    public static function create($object)
    {
        if(empty($object['id']))
        {
            $id = Question::max('id');
            $id++;

            $object['id'] = $id;
        }

        $object['data_lang'] = Question::addDataLang($object['lang_id'], $object['id']);

        return Question::create($object);
    }

    /**
     * @param array     $object     contain properties of question
     * @return \Syscover\Review\Models\Question
     */
    public static function update($object)
    {
        $object = collect($object);

        Question::where('ix', $object->get('ix'))
            ->update([
                'name'          => $object->get('name'),
                'description'   => $object->get('description')
            ]);

        Question::where('id', $object->get('id'))
            ->update([
                'poll_id'       => $object->get('poll_id'),
                'type_id'       => $object->get('type_id'),
                'sort'          => $object->get('sort'),
                'high_score'    => $object->get('high_score')
            ]);

        return Question::find($object->get('ix'));
    }
}