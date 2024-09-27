<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ParkMessage extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'park_messages';

    /**
     * @var string[]
     */
    protected $fillable = ['user_id', 'thread_id', 'message'];

    /**
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return  $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function thread() : BelongsTo
    {
        return  $this->belongsTo(Thread::class);
    }
}
