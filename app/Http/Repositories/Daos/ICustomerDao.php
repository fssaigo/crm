<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/10/9
 * Time: 16:41
 */

namespace App\Http\Repositories\Daos;


interface ICustomerDao
{
    public function findCustomer($search, $offset, $size);
}