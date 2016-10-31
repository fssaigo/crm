<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/10/21
 * Time: 15:01
 */

namespace App\Http\Repositories\Services;


use App\Http\Requests\SysUserContext;

interface IDistribution
{

    /**
     * 分配数据给小组组员
     * @param SysUserContext $sysUserContext
     * @param $ids
     * @param $userId
     * @return mixed
     */
    public function assignByCharge(SysUserContext $sysUserContext, $ids, $userId);


}