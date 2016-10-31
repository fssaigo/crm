<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/9/28
 * Time: 14:56
 */

namespace App\Http\Repositories\Daos;


interface IUserDao
{

    public function findByEmail($name);

    public function findUserByName($merchantId, $name);

    public function findUser($search, $offset, $size);

}