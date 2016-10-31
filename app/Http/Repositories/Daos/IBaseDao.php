<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/9/12
 * Time: 16:58
 */

namespace App\Http\Repositories\Daos;

interface IBaseDao
{

    public function findOne($id);

    public function findByIds($ids);

    public function findByKeyIsVal($key, $val);

    public function findByKeyInVal($key, $val);

    public function findMapByIds(Array $ids, $key);

    public function save($data);

    public function update($data, $data1);

}