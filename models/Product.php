<?php
namespace Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * If set to true the table must contain the columns created_at and updated_at
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * Table columns
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'price',
        'store_id',
        'category_id',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
