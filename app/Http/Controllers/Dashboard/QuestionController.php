<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Quiz\Question\ChangeQuestionOrderRequest;
use App\Http\Requests\Quiz\Question\CreateQuestionRequest;
use App\Http\Requests\Quiz\Question\UpdateQuestionRequest;
use App\Http\Resources\QuestionResource;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Quiz;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class QuestionController extends Controller
{

    /**
     * @param CreateQuestionRequest $request
     * @param int $quiz_id
     * @return JsonResource
     * @throws ForbiddenException
     * @throws NotFoundException
     */
    public function createQuestion(CreateQuestionRequest $request, int $quiz_id): JsonResource
    {
        $this->checkIfExistsQuiz($quiz_id);

        $data = $request->only([
                'title',
                'type',
                'file_type',
                'url',
                'question_required',
            ]) + ['quiz_id' => $quiz_id];

        if (isset($data['file_type']) && $data['file_type'] === 'youtube') {
            $data['url'] = $this->getYoutubeVideoID($data['url']);
        }

        $question = Question::create($data);

        if (!empty($request->file)) {
            $path = ImageService::saveFile($request->file('file'), 'questions/' . $question->id);
            $question->file = $path;
            $question->save();
        }

        return QuestionResource::make($question);
    }


    /**
     * @param UpdateQuestionRequest $request
     * @param int $quiz_id
     * @param int $question_id
     * @return JsonResource
     * @throws ForbiddenException
     * @throws NotFoundException
     */
    public function updateQuestion(UpdateQuestionRequest $request, int $quiz_id, int $question_id): JsonResource
    {
        $this->checkIfExistsQuiz($quiz_id, $question_id);

        $question = $this->checkIfExistsQuestion($question_id);

        if ($request->is_priority){
            $is_priority = true;
        }else{
            $is_priority = false;
        }

        $data = $request->only([
                'title',
                'type',
                'file_type',
                'url',
                'question_required',
            ]) + [
                'quiz_id' => $quiz_id,
                'is_priority' => $is_priority
            ];

        if ($data['type'] === 'file' && isset($data['file_type']) && $data['file_type'] === 'youtube') {
            $data['url'] = $this->getYoutubeVideoID($data['url']);
        }

        if ($request->file('file')) {
            $data['url'] = null;
            $path = ImageService::saveFile($request->file('file'), 'questions/' . $question->id);
            $data['file'] = $path;
        }

        $question->update($data);

        return QuestionResource::make($question);
    }

    public function updateQuestionInfo(Request $request, int $quiz_id, int $question_id)
    {
        $questionInfo = $request->question_info;

        $question = $this->checkIfExistsQuestion($question_id);

        $question->question_info = $questionInfo;

        $question->save();

        return response()->json('success', 200);
    }


    /**
     * @param int $quiz_id
     * @return JsonResource
     */
    public function retrieveAllQuestionByQuizID(int $quiz_id): JsonResource
    {
        $questions = Question::where('quiz_id', $quiz_id)->orderBy('order', 'asc')->get();

        return QuestionResource::collection($questions);
    }


    /**
     * @param int $quiz_id
     * @param int $question_id
     * @return JsonResource
     * @throws ForbiddenException
     * @throws NotFoundException
     */
    public function deleteQuestion(int $quiz_id, int $question_id): JsonResource
    {
        $this->checkIfExistsQuiz($quiz_id, $question_id);

        $question = $this->checkIfExistsQuestion($question_id);

        $question->delete();

        return JsonResource::make([
            'deleted' => true
        ]);
    }


    /**
     * @param ChangeQuestionOrderRequest $request
     * @param int $quiz_id
     * @return JsonResource
     * @throws ForbiddenException
     * @throws NotFoundException
     */
    public function changeQuestionOrderByQuizID(ChangeQuestionOrderRequest $request, int $quiz_id): JsonResource
    {
        $this->checkIfExistsQuiz($quiz_id);

        collect($request->ids)->each(function ($value, $question_id) {
            $question = $this->checkIfExistsQuestion($question_id);

            $question->update(['order' => $value]);
        });

        $questions = Question::where('quiz_id', $quiz_id)->orderBy('order', 'asc')->get();

        return QuestionResource::collection($questions);
    }


    /**
     * @param int $quiz_id
     * @param int $question_id
     * @return JsonResource
     * @throws ForbiddenException
     * @throws NotFoundException
     */
    public function retrieveOneByID(int $quiz_id, int $question_id): JsonResource
    {
        $this->checkIfExistsQuiz($quiz_id, $question_id);

        $question = $this->checkIfExistsQuestion($question_id);

        return QuestionResource::make($question);
    }


    /**
     * @param int $quiz_id
     * @param int $question_id
     * @return JsonResource
     * @throws ForbiddenException
     * @throws NotFoundException
     */
    public function cloneQuestionWithAnswers(int $quiz_id, int $question_id): JsonResource
    {
        $this->checkIfExistsQuiz($quiz_id, $question_id);

        $question = $this->checkIfExistsQuestion($question_id);

        $question_data = Arr::except($question->toArray(), ['id', 'created_at', 'updated_at', 'deleted_at']);

        $question_data['title'] = 'Clone from ' . $question_data['title'];

        $cloned_question = Question::create($question_data);

        $cloned_question_id = $cloned_question->id;

        $question->answers->each(function ($answer) use ($cloned_question_id) {

            $answer_data = Arr::except($answer->toArray(), ['id', 'question_id', 'created_at', 'updated_at', 'deleted_at']);

            Answer::create($answer_data + ['question_id' => $cloned_question_id]);
        });

        return QuestionResource::make($cloned_question->refresh());
    }


    /**
     * @param int $quiz_id
     * @param int|null $question_id
     * @throws ForbiddenException
     * @throws NotFoundException
     */
    public function checkIfExistsQuiz(int $quiz_id, int $question_id = null): void
    {
        $quiz = Quiz::find($quiz_id);

        if (!$quiz) {
            throw new NotFoundException();
        }

        if ($question_id) {
            if (!$quiz->questions->contains('id', $question_id)) {
                throw new ForbiddenException();
            }
        }
    }


    /**
     * @param int $question_id
     * @return Question
     * @throws NotFoundException
     */
    public function checkIfExistsQuestion(int $question_id): Question
    {
        $question = Question::find($question_id);

        if (!$question) {
            throw new NotFoundException();
        }

        return $question;
    }


    /**
     * @param string $url
     * @return string
     */
    public function getYoutubeVideoID(string $url): string
    {
        parse_str(parse_url($url, PHP_URL_QUERY), $my_array_of_vars);
        return $my_array_of_vars['v'];
    }
}
