<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository
{
    public $model;
    public $query;

    abstract public function getModel(): string;
    
    public function __construct()
    {
        $model = $this->getModel();
        $this->model = new $model();
        $this->query = $model::query();
    }

    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model
    {
        return $this->model = $this->getModel()::create($attributes);
    }

    /**
     * @param Model $model
     * @param array $attributes
     * @return Model
     */
    public function update(Model $model, array $attributes): Model
    {
        $model->update($attributes);
        return $model->refresh();
    }

    /**
     * @param Model $model
     * @return mixed
     * @throws \Exception
     */
    public function delete(int $id): bool
    {
        $model = $this->getModel()::findOrfail($id);
        return $model->delete();
    }

}
