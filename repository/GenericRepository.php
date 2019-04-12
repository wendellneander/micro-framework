<?php

namespace Repository;

use Core\Repository;
use Illuminate\Database\Eloquent\Model;
use Models\Generic;

class GenericRepository extends Repository
{
    /**
     * @var Model $model
     */
    protected $model;

    public function __construct(Generic $model)
    {
        parent::__construct($model);
    }
}
