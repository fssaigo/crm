<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/10/8
 * Time: 16:55
 */

namespace App\Http\Repositories\Services;


use App\Http\Requests\SysUserContext;

interface IPond
{

    /**
     * 查询池子种的数据
     * @param SysUserContext $sysUserContext
     * @param $search
     * @param $offset
     * @param $size
     * @return mixed
     */
    public function findPondList(SysUserContext $sysUserContext, $search, $offset, $size);

    /**
     * 将池子种的数据分配给小组
     * @param SysUserContext $sysUserContext
     * @param $ids
     * @param $groupId
     * @return mixed
     */
    public function pondAssigner(SysUserContext $sysUserContext, $ids, $groupId);

}