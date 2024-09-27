<?php

namespace App\Models;

use App\Services\SaveFiles\HasFiles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Kyslik\ColumnSortable\Sortable;

class Reply extends Model implements HasFiles
{
    use HasFactory, Sortable;

    const ACTIVE = 'active';

    /**
     * @var string
     */
    protected $table =  'replies';

    /**
     * @var string[]
     */
    protected $fillable =  ['user_id', 'thread_id', 'parent_id', 'category_id', 'body', 'location', 'status',
        'source_id', 'is_daily_sent', 'is_weekly_sent'];

    /**
     * @return BelongsTo
     */
    public function thread() : BelongsTo
    {
        return $this->belongsTo(Thread::class);
    }

    /**
     * @return BelongsTo
     */
    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function parent() : BelongsTo
    {
        return $this->belongsTo(Reply::class, 'parent_id');
    }

    /**
     * @return HasMany
     */
    public function replies() : HasMany
    {
        return $this->hasMany(Reply::class, 'parent_id');
    }

    /**
     * @return MorphMany
     */
    public function files() : MorphMany
    {
        return $this->morphMany(File::class, 'resource');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::ACTIVE)
            ->where(function ($q) {
                $q->orDoesntHave('parent');
                $q->orWhereHas('parent', function ($q) {
                    $q->where('status', self::ACTIVE);
                });
            });
    }

    /**
     * @return BelongsTo
     */
    public function source(): BelongsTo
    {
        return $this->belongsTo(self::class);
    }
}
