<?php namespace Syscover\Review\Services;

use Syscover\Review\Models\Question;

class QuestionService
{
    public static function create($object)
    {
        QuestionService::checkCreate($object);

        $isNew = false;
        if(empty($object['id']))
        {
            $object['id'] = next_id(Question::class);
            $isNew = true;
        }

        $object['data_lang'] = Question::addDataLang($object['lang_id'], $object['id']);

        $question = Question::create(QuestionService::builder($object));

        // Register question average if is a new element
        if($isNew && $question->type_id === 1)
        {
            QuestionAverageService::create([
                'poll_id'       => $question->poll_id,
                'question_id'   => $question->id
            ]);
        }

        return $question;
    }

    public static function update($object)
    {
        QuestionService::checkUpdate($object);
        Question::where('ix', $object['ix'])->update(QuestionService::builder($object));
        Question::where('id', $object['id'])->update(QuestionService::builder($object, ['poll_id', 'type_id', 'sort', 'high_score']));

        $question = Question::find($object['ix']);

        // if is a score
        if($object['type_id'] === 1 && ! $question->average)
        {
            QuestionAverageService::create([
                'poll_id'       => $question->poll_id,
                'question_id'   => $question->id
            ]);
        }
        elseif($object['type_id'] !== 1 && $question->average)
        {
            $question->average->delete();
        }

        return $question;
    }

    private static function builder($object, $filterKeys = null)
    {
        $object = collect($object);
        if($filterKeys) $object = $object->only($filterKeys);

        return $object->only(['id', 'lang_id', 'poll_id', 'type_id', 'name', 'description', 'sort', 'high_score', 'data_lang'])->toArray();
    }

    private static function checkCreate($object)
    {
        if(empty($object['lang_id']))   throw new \Exception('You have to define a lang_id field to create a question');
        if(empty($object['poll_id']))   throw new \Exception('You have to define a poll_id field to create a question');
        if(empty($object['type_id']))   throw new \Exception('You have to define a type_id field to create a question');
        if(empty($object['name']))      throw new \Exception('You have to define a name field to create a question');
    }

    private static function checkUpdate($object)
    {
        if(empty($object['ix'])) throw new \Exception('You have to define a ix field to update a question');
        if(empty($object['id'])) throw new \Exception('You have to define a id field to update a question');
    }
}