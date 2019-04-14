<?php

namespace Repository;

use Core\Repository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

        if ($name) {
            $query->where('name', 'like', "%$name%");
        }

        if ($onlyWithProducts) {
            $query->whereHas('products');
        }

        return $query->get();
    }

    public function searchByProductNameAndCategory($name, $category, $onlyWithProducts = false)
    {
        $query = $this->model->query()->with([
            'products' => function (HasMany $builder) use ($category, $name) {
                if($name){
                    $builder->where('name', 'like', "%$name%");
                }

                if($category){
                    $builder->where('category_id', $category);
                }
            },
            'products.category'
        ]);


        if ($onlyWithProducts) {
            $query->whereHas('products', function(Builder $builder) use ($name, $category) {
                if($name){
                    $builder->where('name', 'like', "%$name%");
                }

                if($category){
                    $builder->where('category_id', $category);
                }
            });
        }

        return $query->get();
    }

    public function searchByProductNameAndStoreAndCategory($name, $store, $category, $with = [], $onlyWithProducts = false)
    {
        $query = $this->model->query()->with([
            'products' => function (HasMany $builder) use ($category, $name) {
                if($name){
                    $builder->where('name', 'like', "%$name%");
                }

                if($category){
                    $builder->where('category_id', $category);
                }
            }
        ]);

        if($with){
            $query->with($with);
        }

        if ($onlyWithProducts) {
            $query->whereHas('products', function(Builder $builder) use ($name, $category) {
                if($name){
                    $builder->where('name', 'like', "%$name%");
                }

                if($category){
                    $builder->where('category_id', $category);
                }
            });
        }

        $query->where('id', $store);

        return $query->get();
    }

    public function searchProductsByName($name, $with = [], $onlyWithProducts = false)
    {
        $query = $this->model->query()->with($with);

        if ($name) {
            $query->whereHas('products', function (Builder $builder) use ($name) {
                $builder->where('name', 'like', "%$name%");
            });
        }

        if ($onlyWithProducts) {
            $query->whereHas('products');
        }

        return $query->get();
    }

    public function exists($column, $value)
    {
        return $this->model->query()->where($column, $value)->exists();
    }
}
