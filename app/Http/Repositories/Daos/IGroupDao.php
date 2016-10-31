<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/9/18
 * Time: 15:26
 */

namespace App\Http\Repositories\Daos;


interface IGroupDao
{
    public function findByName($name);

    public function findGroup($search, $offset, $size);
    
}