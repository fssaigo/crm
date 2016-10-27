<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/10/10
 * Time: 11:36
 */

namespace App\Http\Repositories\Daos;


interface ICustomerMarkDao
{

    public function findByCustomerId($customerId);

}