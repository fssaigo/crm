<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/9/20
 * Time: 18:09
 */

namespace App\Http\Repositories\Daos;


interface IMerchantDao
{
    public function findMerchant($search, $offset, $size);
}