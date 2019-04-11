<?php
namespace Models;

use Illuminate\Database\Eloquent\Model;

class Generic extends Model
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
    protected $table = 'users';

    /**
     * Table columns
     *
     * @var array
     */
    protected $fillable = [];
}
