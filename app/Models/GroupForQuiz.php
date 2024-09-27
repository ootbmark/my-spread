<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupForQuiz extends Model
{

    protected $fillable = [
        'name'
    ];

    protected $table = 'groups_for_quiz';


    public static function laratablesCustomActions($group)
    {
        return view('dashboard.group_for_quiz.custom._actions', compact('group'))->render();
    }
}
