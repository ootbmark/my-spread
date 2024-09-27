<?php

namespace App\Exports;

use App\Models\UserQuiz;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class QuizAnswerExport implements WithMapping, FromQuery, WithHeadings
{
    use Exportable;

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return UserQuiz::query()->with('quiz_answers', 'user')->whereBetween('id', [13001, 14000]);
    }


    /**
     * @param $quizReport
     * @return array
     */
    public function map($quizReport) : array
    {
        $array = [
            $quizReport->user->student->school->name ?? '',
            $quizReport->user->name ?? '',
            $quizReport->user->student->class ?? '',
        ];
        if ($quizReport->quiz){
            foreach ($quizReport->quiz->questions as $question) {
                $array[] = $quizReport->quiz_answers()->with('answer')->where('question_id', $question->id)->first()->answer->title ?? '';
            }
        }

        return  $array;
    }

    /**
     * @return string[]
     */
    public function headings(): array
    {
        return [
            'School',
            'Student',
            'Class',
            '1',
            '2',
            '3',
            '4',
            '5',
            '6',
            '7',
            '8',
            '9',
            '10',
            '11',
            '12',
            '13',
            '14',
            '15',
            '16',
            '17',
            '18',
            '19',
            '20',
            '21',
            '22',
            '23',
            '24',
            '25',
            '26',
            '27',
            '28',
            '29',
            '30',
        ];
    }

}
