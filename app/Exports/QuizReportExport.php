<?php

namespace App\Exports;

use App\Models\QuizReport;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;

class QuizReportExport implements WithMapping, FromQuery, WithHeadings
{
    use Exportable;

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return QuizReport::query();
    }


    /**
     * @param $quizReport
     * @return array
     */
    public function map($quizReport) : array
    {

        return [
            $quizReport->name,
            $quizReport->quiz->title ?? '',
            $quizReport->questions_answers,
            $quizReport->quiz_duration,
            $quizReport->created_at,
        ];
    }

    /**
     * @return string[]
     */
    public function headings(): array
    {
        return [
            'Name',
            'Form',
            'Quiz',
            'Questions/Answers',
            'Duration',
            'Created at',
        ];
    }
}
