<?php


namespace App\Services;


use App\Models\QuizAnswer;

class ReportAnswersCreatorService
{
    public function createAnswers(array $question, int $questionId, int $newReportId): void
    {
        if ($question['type'] === 'text' || $question['type'] === 'textarea') {
            $text = $question['answer']['text'] ?? null;
            if (!empty($text)) {
                QuizAnswer::create([
                    'quiz_report_id' => $newReportId,
                    'question_id' => $questionId,
                    'answer_id' => null,
                    'text' => $text,
                ]);
            }
        } elseif ($question['type'] === 'circling') {
            $quizAnswer = QuizAnswer::create([
                'quiz_report_id' => $newReportId,
                'question_id' => $questionId,
                'answer_id' => null,
                'text' => $question['answer']['text'] ?? null,
            ]);

            $quizAnswer->answers()->attach($question['answer']['ids'] ?? []);
        } elseif ($question['type'] === 'file' || $question['type'] === 'multiple') {
            $answerIds = $question['answer']['ids'] ?? [];
            foreach ($answerIds as $answerId) {
                QuizAnswer::create([
                    'quiz_report_id' => $newReportId,
                    'question_id' => $questionId,
                    'answer_id' => $answerId,
                    'text' => null,
                ]);
            }
        } elseif ($question['type'] === 'dropdown' || $question['type'] === 'radio') {
            $answerId = $question['answer']['id'] ?? null;
            if (!empty($answerId)) {
                QuizAnswer::create([
                    'quiz_report_id' => $newReportId,
                    'question_id' => $questionId,
                    'answer_id' => $answerId,
                    'text' => null,
                ]);
            }
        }
    }
}
