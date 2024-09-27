<?php

namespace App\Exports;

use App\Imports\Mapping\QuizMapping;
use App\Models\Quiz;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Symfony\Component\Console\Formatter\OutputFormatterStyleInterface;
use Symfony\Component\Console\Formatter\WrappableOutputFormatterInterface;

class QuizExport implements FromView, WrappableOutputFormatterInterface
{

    protected $quiz_id;

    public function __construct($quiz_id = null)
    {
        return $this->quiz_id = $quiz_id;
    }

    public function view(): View
    {
        if ($this->quiz_id) {
            $quizzes = Quiz::query()->where('id', $this->quiz_id)->with(['quiz_reports' => function ($q) {
                $q->orderBy('group_id', 'desc');
            }])->get();

        } else {
            $quizzes = Quiz::with(['quiz_reports' => function ($q) {
                $q->orderBy('group_id', 'desc');
            }])->get();
        }

        $quizMapping = new QuizMapping();

        return view('dashboard.quiz.export_excel', [
            'quizzes' => $quizzes,
            'mapping' => $quizMapping,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function setDecorated(bool $decorated)
    {
        // TODO: Implement setDecorated() method.
    }

    /**
     * @inheritDoc
     */
    public function isDecorated()
    {
        // TODO: Implement isDecorated() method.
    }

    /**
     * @inheritDoc
     */
    public function setStyle(string $name, OutputFormatterStyleInterface $style)
    {
        // TODO: Implement setStyle() method.
    }

    /**
     * @inheritDoc
     */
    public function hasStyle(string $name)
    {
        // TODO: Implement hasStyle() method.
    }

    /**
     * @inheritDoc
     */
    public function getStyle(string $name)
    {
        // TODO: Implement getStyle() method.
    }

    /**
     * @inheritDoc
     */
    public function format(?string $message)
    {
        // TODO: Implement format() method.
    }

    /**
     * @inheritDoc
     */
    public function formatAndWrap(?string $message, int $width)
    {
        // TODO: Implement formatAndWrap() method.
    }
}
