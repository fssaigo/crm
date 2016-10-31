<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/10/27
 * Time: 14:17
 */

namespace App\Http\Repositories\Daos;


interface IMenuPermissionDao
{

    public function findMenuByRoleId($roleId);

}