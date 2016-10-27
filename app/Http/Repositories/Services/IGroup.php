<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/9/18
 * Time: 15:15
 */

namespace App\Http\Repositories\Services;

use App\Http\Requests\SysUserContext;

interface IGroup
{

    /**
     * @param $id
     * @return mixed
     */
    public function findById($id);

    /**
     * 查询小组
     * @param $search
     * @param $offset
     * @param $size
     * @return mixed
     */
    public function findByList($search, $offset, $size);

    /**
     * @param SysUserContext $sysUserContext
     * @param $input
     * @return mixed
     */
    public function saveGroup(SysUserContext $sysUserContext, $input);

    /**
     * @param SysUserContext $sysUserContext
     * @param $input
     * @param $id
     * @return mixed
     */
    public function editGroup(SysUserContext $sysUserContext, $input, $id);

    /**
     * 查询小组的组长ID
     * @param $groupId
     * @return mixed
     */
    public function findGroupLeaderId($groupId);

}