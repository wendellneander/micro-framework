<?php

namespace Repository;

use Core\Repository;
use Illuminate\Database\Eloquent\Builder;
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

    public function searchByName($name, $with = [], $onlyWithProducts = false)
    {
        $query = $this->model->query()->with($with);

        if($name){
            $query->where('name', 'like', "%$name%");
        }

        if($onlyWithProducts){
            $query->whereHas('products');
        }

        return $query->get();
    }

    public function searchByProductName($name, $with = [], $onlyWithProducts = false)
    {
        $query = $this->model->query()->with($with);

        if($name){
            $query->whereHas('products', function(Builder $builder) use ($name) {
                $builder->where('name', 'like', "%$name%");
            });
        }

        if($onlyWithProducts){
            $query->whereHas('products');
        }

        return $query->get();
    }
}
