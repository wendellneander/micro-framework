<?php
namespace Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $timestamps = false;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password'
    ];
}
