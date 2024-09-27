<?php


namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function findOrFail(int $id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function destroy(int $id): bool
    {
        $this->model->findOrFail($id);

        return $this->model->destroy($id);
    }

    /**
     * @return Model[]
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * @param $orderBy
     * @return mixed
     */
    public function getOrderBy($orderBy)
    {
        return $this->model->active()->orderBy($orderBy)->get();
    }
}
