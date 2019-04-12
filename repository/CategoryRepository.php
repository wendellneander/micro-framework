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
}
