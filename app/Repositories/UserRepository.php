<?php


namespace App\Repositories;


use App\Models\User;

class UserRepository extends BaseRepository
{
    /**
     * UserRepository constructor.
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     * @param $request
     * @return null
     */
    public function getSearchedUsers($request)
    {
        $searchedUsers = null;

        if (($request->type && $request->id) || $request->location || $request->search) {
            $searchedUsers = $this->model
                ->active()
                ->searchType($request->type, $request->id)
                ->searchLocation($request->location)
                ->searchName($request->search)
                ->orderBy('last_name')
                ->paginate(20);
        }
        return $searchedUsers;
    }
}
