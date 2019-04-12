<?php

namespace Repository;

use Core\Repository;
use Models\Category;

class CategoryRepository extends Repository
{
    /**
     * @var Category $model
     */
    protected $model;

    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    public function searchByName($name, $with = [])
    {
        $query = $this->model->query()->with($with);

        if($name){
            $query->where('name', 'like', "%$name%");
        }

        return $query->get();
    }
}
