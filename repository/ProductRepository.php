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
}
