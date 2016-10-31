<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/10/14
 * Time: 15:49
 */

namespace App\Http\Repositories\Daos;


interface IChinaDao
{

    public function province(Array $code);

    public function city(Array $code);

    public function district(Array $code);

}