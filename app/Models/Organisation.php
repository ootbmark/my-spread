<?php

namespace App\Models;

use App\Exceptions\EnvironmentException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kyslik\ColumnSortable\Sortable;

class Organisation extends Model
{
    use HasFactory, Sortable;

    const ACTIVE = 'active';
    const NEW = 'new';
    const DELETED = 'deleted';

    /**
     * @var string
     */
    protected $table = 'organisations';

    /**
     * @var string[]
     */
    protected $fillable = ['name', 'short_name', 'email', 'address', 'phone', 'website', 'logo', 'status', 'type'];

    /**
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getLogoAttribute($value)
    {
        if (!$value) {
            return '/img/default_org.png';
        }
        return  '/storage' . $value;
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::ACTIVE);
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
        $envKeyFallbackOrganisation = 'FALLBACK_ID_ORGANISATION';
        $id = 23/* getenv($envKeyFallbackOrganisation) */ /* env('FALLBACK_ID_ORGANISATION') */;
        if ($id === false) {
            EnvironmentException::missing($envKeyFallbackOrganisation);
        }
        if (!is_numeric($id)) {
            EnvironmentException::invalid($envKeyFallbackOrganisation);
        }
        $organisationExists = self::where('id', $id)->exists();
        if (!$organisationExists) {
            throw new EnvironmentException("Fallback organisation with the specified id doesn't exists: $id");
        }

        return (int)$id;
    }

    protected static function boot()
    {
        parent::boot();

        self::updating(function (self $organisation) {
            if ($organisation->status === self::DELETED) {
                if ($organisation->isFallback()) {
                    throw new \LogicException('Can not delete fallback organisation');
                }
                $fallbackId = self::getFallbackId();
                $organisation->users()->update(
                    ['organisation_id' => $fallbackId]
                );
            }
        });

        self::deleting(function (self $organisation) {
            if ($organisation->isFallback()) {
                throw new \LogicException('Can not delete fallback organisation');
            }
            $fallbackId = self::getFallbackId();
            $organisation->users()->update(
                ['organisation_id' => $fallbackId]
            );
        });
    }
}
