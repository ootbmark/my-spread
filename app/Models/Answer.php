<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Answer extends Model
{
    use SoftDeletes;

    protected $table = 'answers';

    protected $fillable = [
        'question_id',
        'title',
        'is_right',
        'file',
        'file_type',
        'url',
        'order'
    ];

    protected $appends = [
        'file_url'
    ];

    protected $casts = [
        'is_right' => 'boolean'
    ];

    public function getFileUrlAttribute()
    {
        return Storage::url($this->file);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function quiz_answer()
    {
       return $this->belongsToMany(QuizAnswer::class, 'circling_answers', 'answer_id', 'quiz_answer_id', 'id');
    }

}
