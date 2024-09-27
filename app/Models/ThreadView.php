<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThreadView extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'thread_views';

    /**
     * @var string[]
     */
    protected $fillable = ['user_id', 'thread_id', 'count'];
}
