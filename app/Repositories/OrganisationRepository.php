<?php


namespace App\Repositories;


use App\Models\Organisation;

class OrganisationRepository extends BaseRepository
{
    /**
     * OrganisationRepository constructor.
     * @param Organisation $model
     */
    public function __construct(Organisation $model)
    {
        parent::__construct($model);
    }
}
