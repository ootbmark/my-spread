<?php

namespace App\Models;

use App\Exceptions\EnvironmentException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kyslik\ColumnSortable\Sortable;

class University extends Model
{
    use HasFactory, Sortable;

    const ACTIVE = 'active';
    const NEW = 'new';
    const DELETED = 'deleted';

    /**
     * @var string
     */
    protected $table = 'universities';

    /**
     * @var string[]
     */
    protected $fillable = ['name', 'status'];

    /**
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * @return bool
     *
     * @throws EnvironmentException
     */
    public function isFallback(): bool
    {
        $id = self::getFallbackId();

        return $this->getKey() === $id;
    }

    /**
     * @return int
     *
     * @throws EnvironmentException
     */
    public static function getFallbackId(): int
    {
        $envKeyFallbackUniversity = 'FALLBACK_ID_UNIVERSITY';
        $id = 1 /* getenv($envKeyFallbackUniversity) */;
        if ($id === false) {
            EnvironmentException::missing($envKeyFallbackUniversity);
        }
        if (!is_numeric($id)) {
            EnvironmentException::invalid($envKeyFallbackUniversity);
        }
        $universityExists = self::where('id', $id)->exists();
        if (!$universityExists) {
            throw new EnvironmentException("Fallback University with the specified id doesn't exists: $id");
        }

        return (int)$id;
    }

    protected static function boot()
    {
        parent::boot();

        self::updating(function (self $university) {
            if ($university->status === self::DELETED) {
                if ($university->isFallback()) {
                    throw new \LogicException('Can not delete fallback university');
                }
                $fallbackId = self::getFallbackId();
                $university->users()->update(
                    ['university_id' => $fallbackId]
                );
            }
        });

        self::deleting(function (self $university) {
            if ($university->isFallback()) {
                throw new \LogicException('Can not delete fallback university');
            }
            $fallbackId = self::getFallbackId();
            $university->users()->update(
                ['university_id' => $fallbackId]
            );
        });
    }

}
