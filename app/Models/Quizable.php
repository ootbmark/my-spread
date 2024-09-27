<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quizable extends Model
{
    protected $table = 'quizables';

    protected $fillable = [
        'quiz_id',
        'quizable_id',
        'quizable_type'
    ];

    public static function saveQuiz($section, $quiz_id)
    {
        self::where('quizable_id', $section->id)->where('quizable_type', get_class($section))->where('quiz_id', $quiz_id)->delete();

        self::create([
            'quiz_id' => $quiz_id,
            'quizable_id' => $section->id,
            'quizable_type' => get_class($section),
        ]);
    }

    public static function saveLessonQuiz($lessonItem, $quiz_id)
    {
        self::where('quizable_id', $lessonItem->id)->where('quizable_type', get_class($lessonItem))->delete();

        if ($quiz_id){
            self::create([
                'quiz_id' => $quiz_id,
                'quizable_id' => $lessonItem->id,
                'quizable_type' => get_class($lessonItem),
            ]);
        }
    }

    public static function updateQuiz($section, $quiz_id, $quiz_id_up)
    {
        $quiz = self::where('quizable_id', $section->id)->where('quizable_type', get_class($section))->where('quiz_id', $quiz_id_up)->first();

        $quiz->update([
            'quiz_id' => $quiz_id,
        ]);

    }

    /**
     * Get the post that owns the comment.
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }
}
