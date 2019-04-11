<?php
/**
 * Created by PhpStorm.
 * User: devmaker
 * Date: 2019-04-11
 * Time: 17:13
 */

namespace Repository;


interface RepositoryInterface
{
    public function all();

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);

    public function show($id);

    public function getModel();

    public function setModel($model);

    public function with($relations);
}
