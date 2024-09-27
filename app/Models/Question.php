<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Question extends Model
{
    use SoftDeletes;

    protected $table = 'questions';

    protected $fillable = [
        'quiz_id',
        'title',
        'type',
        'file',
        'file_type',
        'url',
        'order',
        'is_priority',
        'question_info',
        'question_required',
    ];


    protected $appends = [
        'file_url'
    ];

    public function getFileUrlAttribute()
    {
        return Storage::url($this->file);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class)->orderBy('order', 'asc');
    }

}
