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
}
