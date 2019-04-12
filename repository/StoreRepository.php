<?php

namespace Repository;

use Core\Repository;
use Models\Store;

class StoreRepository extends Repository
{
    /**
     * @var Store $model
     */
    protected $model;

    public function __construct(Store $model)
    {
        parent::__construct($model);
    }

    public function searchByName(string $name)
    {
        if(!$name){
            return $this->all();
        }

        return $this->model->query()->where('name', 'like', "%$name%")->get();
    }
}
