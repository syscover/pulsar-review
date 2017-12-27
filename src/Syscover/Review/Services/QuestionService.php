<?php namespace Syscover\Review\Services;

use Syscover\Core\Services\SQLService;
use Syscover\Review\Models\Question;
use Syscover\Review\Models\QuestionAverage;

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

        $question = Question::create($object);

        // Register question average if is a new element
        if(empty($object['id']) && $question->type_id === 1)
        {
            QuestionAverageService::create([
                'question_id' => $id
            ]);
        }

        return $question;
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


        // Question average operations
        $questionAverage = QuestionAverage::where('question_id', $object->get('id'))->first();

        // if is a score
        if($object->get('type_id') === 1)
        {
            if(! $questionAverage)
            {
                QuestionAverageService::create([
                    'question_id' => $object->get('id')
                ]);
            }
        }
        elseif($questionAverage)
        {
            $questionAverage->delete();
        }

        return Question::find($object->get('ix'));
    }

    /**
     * @param   $id
     * @param   $lang
     * @return  \Syscover\Review\Models\Question
     */
    public static function delete($id, $lang)
    {
        $object = SQLService::destroyRecord($id, Question::class, $lang);

        return $object;
    }
}