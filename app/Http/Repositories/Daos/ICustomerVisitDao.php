<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/10/14
 * Time: 16:28
 */

namespace App\Http\Repositories\Daos;


interface ICustomerVisitDao
{
    public function visits($search, $offset, $size);
}