<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;

class Group extends Model
{
    use HasFactory, Sortable;

    const ACTIVE = 'active';

    const GENERAL_ID = '59';

    /**
     * @var
     */
    protected $table = 'groups';

    /**
     * @var array
     */
    protected $fillable = ['name', 'description', 'parent_id', 'type', 'status'];

    /**
     * @var string[]
     */
    public $sortableAs = ['threads_count', 'replies_count'];

    /**
     * @return BelongsTo
     */
    public function parent() : BelongsTo
    {
        return $this->belongsTo(Group::class, 'parent_id');
    }

    /**
     * @return HasMany
     */
    public function groups() : HasMany
    {
        return $this->hasMany(Group::class, 'parent_id');
    }

    /**
     * @return HasMany
     */
    public function threads() : HasMany
    {
        return $this->hasMany(Thread::class);
    }

    /**
     * @return HasOne
     */
    public function last_thread() : HasOne
    {
        return $this->hasOne(Thread::class)->orderBy('id', 'desc');
    }

    /**
     * Get all of the posts for the country.
     */
    public function replies()
    {
        return $this->hasManyThrough(Reply::class, Thread::class);
    }

    /**
     * @return BelongsToMany
     */
    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_groups');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::ACTIVE);
    }


}
