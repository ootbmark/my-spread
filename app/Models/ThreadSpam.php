<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Model;

class ThreadSpam extends Model
{
    protected $fillable =  [
        'user_id',
        'group_id',
        'subject',
        'body',
        'location',
        'is_closed',
        'status',
        'source_id',
        'is_daily_sent',
        'is_weekly_sent',
        'activity_date'
    ];
    /**
     * @var string[]
     */
    protected $dates = ['activity_date'];

    /**
     * @var string[]
     */
    public $sortableAs = ['replies_count', 'active_replies_count'];

    /**
     * @param $query
     * @param $direction
     * @return mixed
     */
    public function userSortable($query, $direction)
    {
        return $query->leftJoin('users', 'threads.user_id', '=', 'users.id')
            ->orderBy('users.first_name', $direction)
            ->withCount('replies');
    }

    /**
     * @param $query
     * @param $direction
     * @return mixed
     */
    public function groupSortable($query, $direction)
    {
        return $query->leftJoin('groups', 'threads.group_id', '=', 'groups.id')
            ->orderBy('groups.name', $direction)
            ->withCount('replies');
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param $query
     * @return mixed
     */
    /*  public function scopeActive($query)
    {
        return $query->where('threads.status', self::ACTIVE);
    } */

    /**
     * @return BelongsTo
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * @return HasMany
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * @return HasMany
     */
    public function active_replies(): HasMany
    {
        return $this->hasMany(Reply::class)->active();
    }

    /**
     * @return HasMany
     */
    public function views(): HasMany
    {
        return $this->hasMany(ThreadView::class);
    }

    /**
     * @return MorphMany
     */
    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'resource');
    }

    /**
     * @return BelongsTo
     */
    public function source(): BelongsTo
    {
        return $this->belongsTo(self::class);
    }
}
