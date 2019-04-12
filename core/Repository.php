<?php

namespace Core;

use Illuminate\Database\Eloquent\Model;
use Interfaces\RepositoryInterface;

abstract class Repository implements RepositoryInterface
{
    /**
     * @var Model $model
     */
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function create(array $data)
    {
        return $this->model->query()->create($data);
    }

    public function update(array $data, $id)
    {
        $record = $this->model->query()->find($id);

        return $record->update($data);
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function show($id)
    {
        return $this->model->query()->findOrFail($id);
    }
}
