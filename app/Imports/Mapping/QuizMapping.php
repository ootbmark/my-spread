<?php


namespace App\Imports\Mapping;


use App\Models\Answer;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizAnswer;
use App\Models\QuizReport;
use InvalidArgumentException;
use LogicException;

class QuizMapping
{
    /** @var Quiz|null */
    protected $quiz = null;

    protected $baseMap = [
        'id' => 'ID',
        'status' => 'Value',
        'status_effort' => 'Effort',
        'priority' => 'Current Priority',
        'report_status' => 'Status',
        'action_party' => 'Action Party',
        'focal_point' => 'Focal Point',
        'target_date' => 'Target Date',
        'business_partner' => 'Lead Business Partner',
    ];

    protected $dynamicMap = [];

    protected $questionMap = [];

    public function __construct(?Quiz $quiz = null)
    {
        if ($quiz !== null) {
            $this->setQuiz($quiz);
        }
    }

    public function setQuiz(Quiz $quiz): void
    {
        $this->quiz = $quiz;
        $this->initDynamicMap();
        $this->initQuestionMap();
    }

    protected function initDynamicMap(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            $key = "is_verification_$i";
            $column = "verification_text_$i";
            $this->dynamicMap[$key] = "($i) {$this->quiz->$column}";
        }
    }

    protected function initQuestionMap(): void
    {
        foreach ($this->quiz->questions as $index => $question) {
            $questionNumber = $index + 1;
            $this->questionMap[$question->id] = "($questionNumber) {$question->title}";
        }
    }

    /**
     * @param string $key
     *
     * @return string
     *
     * @throws  InvalidArgumentException|LogicException
     */
    public function getTitleForKey(string $key): string
    {
        if ($this->quiz === null) {
            throw new LogicException('Quiz not set');
        }

        $title = $this->baseMap[$key]
            ?? $this->dynamicMap[$key]
            ?? $this->questionMap[$key]
            ?? null;
        if ($title === null) {
            throw new InvalidArgumentException("Invalid key given: $key");
        }

        return $title;
    }

    /**
     * @param string $title
     *
     * @return string|null
     *
     * @throws LogicException
     */
    public function getKeyForTitle(string $title): ?string
    {
        if ($this->quiz === null) {
            throw new LogicException('Quiz not set');
        }

        $key = array_search($title, $this->baseMap);
        if ($key === false) {
            $key = array_search($title, $this->dynamicMap);
        }
        if ($key === false) {
            $key = null;
        }

        return $key;
    }

    /**
     * @param string $title
     *
     * @return string|null
     *
     * @throws LogicException
     */
    public function getKeyForQuestion(string $title): ?string
    {
        if ($this->quiz === null) {
            throw new LogicException('Quiz not set');
        }

        $key = array_search($title, $this->questionMap);
        if ($key === false) {
            $key = null;
        }

        return $key;
    }

    /**
     * @param QuizReport $report
     * @param Question $question
     *
     * @return string|null
     */
    public function answersToString(QuizReport $report, Question $question): ?string
    {
        $quizAnswers = QuizAnswer::query()
            ->where('quiz_report_id', $report->id)
            ->where('question_id', $question->id)
            ->get();

        if (!$quizAnswers->isEmpty()) {
            if ($question->type === 'text' || $question->type === 'textarea') {
                return $quizAnswers->first()->text;
            }
            if ($question->type === 'circling') {
                $circlingAnswers = $quizAnswers->first()->answers;
                $text = '';
                if (!$circlingAnswers->isEmpty()) {
                    $text .= implode(' / ', $circlingAnswers->pluck('title')->toArray()) . ": ";
                }
                $text .= $quizAnswers->first()->text;

                return $text;
            }
            if ($question->type === 'multiple') {
                return $quizAnswers->implode('answer.title', ' / ');
            }
            if ($question->type === 'file') {
                return $quizAnswers->implode('answer.id', ' / ');
            }
            if ($question->type === 'dropdown' || $question->type === 'radio') {
                return $quizAnswers->first()->answer->title;
            }
        }

        return null;
    }

    public function rawAnswerToArray(int $questionId, string $rawAnswer): array
    {
        $question = Question::findOrFail($questionId);

        $result = [
            'type' => $question->type,
        ];
        if ($question->type === 'text' || $question->type === 'textarea') {
            $result['answer']['text'] = trim($rawAnswer);
        } elseif ($question->type === 'circling') {

            $parts = explode(':', $rawAnswer);
            $text = trim($parts[count($parts) - 1]);
            if ($text === '') {
                $text = null;
            }
            $options = explode('/', implode(':', array_slice($parts, 0, -1)));
            $optionIds = [];
            foreach ($options as $option) {
                $option = trim($option);
                if ($option === '') {
                    continue;
                }

                $option = Answer::query()
                    ->where('question_id', $questionId)
                    ->where('title', $option)
                    ->first();
                if ($option !== null) {
                    $optionIds[] = $option->id;
                }
            }

            $result['answer']['text'] = $text;
            $result['answer']['ids'] = $optionIds;
        } elseif ($question->type === 'multiple' || $question->type === 'file') {
            $options = explode('/', $rawAnswer);
            $optionIds = [];
            foreach ($options as $option) {
                $option = trim($option);
                if ($option === '') {
                    continue;
                }

                if ($question->type === 'multiple') {
                    $option = Answer::query()
                        ->where('question_id', $questionId)
                        ->where('title', $option)
                        ->first();
                } else {
                    $option = Answer::query()
                        ->where('question_id', $questionId)
                        ->where('id', $option)
                        ->first();
                }

                if ($option !== null) {
                    $optionIds[] = $option->id;
                }
            }

            $result['answer']['ids'] = $optionIds;
        } elseif ($question->type === 'dropdown' || $question->type === 'radio') {
            $optionId = null;
            $option = trim($rawAnswer);
            if ($option !== '') {
                $option = Answer::query()
                    ->where('question_id', $questionId)
                    ->where('title', $option)
                    ->first();

                $optionId = $option->id ?? null;
            }

            $result['answer']['id'] = $optionId;
        }

        return $result;
    }

    public function degreeValueToString(?string $value): string
    {
        return !empty($value) ? strtoupper(substr($value, 0, 1)) : '--';
    }

    public function stringToDegreeValue(string $value): ?string
    {
        switch (strtoupper($value)) {
            case 'L': return 'low';
            case 'M': return 'medium';
            case 'H': return 'high';
            default : return null;
        }
    }

    public function booleanToString(bool $value): string
    {
        return $value ? 'Y' : '';
    }

    public function stringToBoolean(?string $value): bool
    {
        return $value !== null && strtoupper($value) === 'Y';
    }
}
