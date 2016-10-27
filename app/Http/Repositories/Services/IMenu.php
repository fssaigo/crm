<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/10/20
 * Time: 14:58
 */

namespace App\Http\Repositories\Services;


use App\Http\Requests\SysUserContext;

interface IMenu
{

    public function nav(SysUserContext $sysUserContext);

}