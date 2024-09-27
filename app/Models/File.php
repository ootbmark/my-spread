<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'files';

    /**
     * @var string[]
     */
    protected $fillable = ['resource_id', 'resource_type', 'path', 'name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function resource()
    {
        return $this->morphTo();
    }


    /**
     * @param $value
     * @return mixed
     */
    public function getPathAttribute($value)
    {
        return  '/storage' . $value;
    }
}
