<?php


namespace App\Services\SaveFiles;


use Illuminate\Database\Eloquent\Relations\MorphMany;

interface HasFiles
{

    public function files() : MorphMany;

    public function getKey();
}
