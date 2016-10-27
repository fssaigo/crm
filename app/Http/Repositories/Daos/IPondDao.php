<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/10/8
 * Time: 17:25
 */

namespace App\Http\Repositories\Daos;


interface IPondDao
{
    public function findPond($search, $offset, $size);
}