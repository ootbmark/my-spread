<?php

namespace App\Imports;


use App\Imports\Mapping\QuizMapping;
use App\Models\GroupForQuiz;
use App\Models\Quiz;
use App\Models\QuizReport;
use App\Services\ReportAnswersCreatorService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class QuizReportsImport implements ToCollection, WithStartRow
{
    /** @var Quiz Quiz */
    private $quiz;

    /** @var QuizMapping */
    private $quizMapping;

    /** @var ReportAnswersCreatorService */
    private $answersCreator;

    /** @var GroupForQuiz|null */
    private $group = null;

    /** @var array  */
    private $head = [];

    /** @var array  */
    private $questions = [];

    /** @var int */
    private $reportCount;

    /** @var int */
    private $performedReportCount;

    public function __construct(Quiz $quiz, QuizMapping $quizMapping, ReportAnswersCreatorService $answersCreator)
    {
        $this->quiz = $quiz;
        $this->quizMapping = $quizMapping;
        $this->answersCreator = $answersCreator;
        $this->reportCount = 0;
        $this->performedReportCount = 0;
    }

    public function startRow(): int
    {
        return 8;
    }

    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            if ($row[0] === 'No.') {
                $this->head = [];
                foreach ($row as $index => $title) {
                    $key = $this->getQuizMapping()->getKeyForTitle($title);
                    if ($key !== null) {
                        $this->head[$index] = $key;
                    }
                    $key = $this->getQuizMapping()->getKeyForQuestion($title);
                    if ($key !== null) {
                        $this->questions[$index] = $key;
                    }
                }

                continue;
            }

            if ($row[0] === 'Group') {

                $this->group = GroupForQuiz::firstWhere('name', explode('. ', $row[2])[1]);
                continue;
            }

            if (strpos($row[0], ',') === false) {
                $this->group = null;
            }

            $result = [
                'questions' => [],
            ];
            foreach ($row->toArray() as $index => $item) {
                if (array_key_exists($index, $this->head)) {
                    $result[$this->head[$index]] = $item;
                } elseif (array_key_exists($index, $this->questions)) {
                    $result['questions'][$this->questions[$index]] = $item;
                }
            }
            $result['group_id'] = $this->group->id ?? null;

            $this->reportCount++;
            if ($this->createOrUpdateReport($result)) {
                $this->performedReportCount++;
            }
        }
    }

    private function createOrUpdateReport(array $data): bool
    {
        if ($data['id'] === null) {
            return $this->createReport($data);
        } else {
            return $this->updateReport($data);
        }
    }

    private function updateReport(array $data): bool
    {
        $report = QuizReport::find($data['id']);

        if ($report === null || $report->quiz->id !== $this->getQuiz()->id) {

            return false;
        }

        $user = Auth::user();
        if (!$user->isAdmin()) {
            abort(403, 'Access Denied');
        }

        $newReport = $report->replicate()->fill([
            'group_id' => $data['group_id'],
            'parent_id' => null,
            'questions_count' => $report->quiz->questions->count(),
            'answers_count' => $report->quiz_answers->count(),
            'questions_answers' => "{$report->quiz->questions->count()} / {$report->quiz_answers()->groupBy('question_id')->get()->count()}",
            'status' => $this->getQuizMapping()->stringToDegreeValue($data['status']),
            'status_effort' => $this->getQuizMapping()->stringToDegreeValue($data['status_effort']),
            'priority' => $this->getQuizMapping()->stringToDegreeValue($data['priority']),
            'action_party' => $data['action_party'] === '--' ? null : $data['action_party'],
            'focal_point' => $data['focal_point'] === '--' ? null : $data['focal_point'],
            'target_date' => $data['target_date'] === '--' ? null : $data['target_date'],
            'business_partner' => $data['business_partner'] === '--' ? null : $data['business_partner'],
            'is_verification_1' => $this->getQuizMapping()->stringToBoolean($data['is_verification_1']),
            'is_verification_2' => $this->getQuizMapping()->stringToBoolean($data['is_verification_2']),
            'is_verification_3' => $this->getQuizMapping()->stringToBoolean($data['is_verification_3']),
            'is_verification_4' => $this->getQuizMapping()->stringToBoolean($data['is_verification_4']),
            'is_verification_5' => $this->getQuizMapping()->stringToBoolean($data['is_verification_5']),
        ]);

        $newReport->save();

        $report->update([
            'parent_id' => $newReport->id,
        ]);

        foreach ($data['questions'] as $questionId => $rawAnswer) {
            if ($rawAnswer === null) {
                $rawAnswer = '';
            }
            $question = $this->getQuizMapping()->rawAnswerToArray($questionId, $rawAnswer);

            $this->getAnswersCreator()->createAnswers($question, $questionId, $newReport->id);
        }

        return true;
    }

    private function createReport(array $data): bool
    {
        $report = QuizReport::create([
            'quiz_id' => $this->getQuiz()->id,
            'user_id' => Auth::user()->id,
            'parent_id' => null,
            'group_id' => $data['group_id'],
            'name' => Auth::user()->name,
            'questions_count' => $this->getQuiz()->questions->count(),
            'answers_count' => 0,
            'quiz_duration' => null,
            'questions_answers' => null,
            'status' => $this->getQuizMapping()->stringToDegreeValue($data['status']),
            'status_effort' => $this->getQuizMapping()->stringToDegreeValue($data['status_effort']),
            'priority' => $this->getQuizMapping()->stringToDegreeValue($data['priority']),
            'action_party' => $data['action_party'] === '--' ? null : $data['action_party'],
            'focal_point' => $data['focal_point'] === '--' ? null : $data['focal_point'],
            'target_date' => $data['target_date'] === '--' ? null : $data['target_date'],
            'business_partner' => $data['business_partner'] === '--' ? null : $data['business_partner'],
            'is_verification_1' => $this->getQuizMapping()->stringToBoolean($data['is_verification_1']),
            'is_verification_2' => $this->getQuizMapping()->stringToBoolean($data['is_verification_2']),
            'is_verification_3' => $this->getQuizMapping()->stringToBoolean($data['is_verification_3']),
            'is_verification_4' => $this->getQuizMapping()->stringToBoolean($data['is_verification_4']),
            'is_verification_5' => $this->getQuizMapping()->stringToBoolean($data['is_verification_5']),
        ]);

        foreach ($data['questions'] as $questionId => $rawAnswer) {
            if ($rawAnswer === null) {
                $rawAnswer = '';
            }
            $question = $this->getQuizMapping()->rawAnswerToArray($questionId, $rawAnswer);

            $this->getAnswersCreator()->createAnswers($question, $questionId, $report->id);
        }

        return true;
    }

    private function getQuizMapping(): QuizMapping
    {
        return $this->quizMapping;
    }

    private function getAnswersCreator(): ReportAnswersCreatorService
    {
        return $this->answersCreator;
    }

    private function getQuiz(): Quiz
    {
        return $this->quiz;
    }

    public function getReportCount(): int
    {
        return $this->reportCount;
    }

    public function getPerformedReportCount(): int
    {
        return $this->performedReportCount;
    }
}
