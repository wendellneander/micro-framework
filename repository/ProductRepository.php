<?php

namespace Repository;

use Core\Repository;
use Models\Product;

class ProductRepository extends Repository
{
    /**
     * @var Product $model
     */
    protected $model;

    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    public function searchByName($name)
    {
        if(!$name){
            return $this->all();
        }

        return $this->model->query()->where('name', 'like', "%$name%")->get();
    }
}
