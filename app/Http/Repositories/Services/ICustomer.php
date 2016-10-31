<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/10/11
 * Time: 11:51
 */

namespace App\Http\Repositories\Services;


use App\Http\Requests\SysUserContext;

interface ICustomer
{

    public function findById($id);

    /**
     * 查询客户资料
     * @param SysUserContext $sysUserContext
     * @param $search
     * @param $offset
     * @param $size
     * @return mixed
     */
    public function lists(SysUserContext $sysUserContext, $search, $offset, $size);

    /**
     * 新增客户资料
     * @param SysUserContext $sysUserContext
     * @param $data
     * @return mixed
     */
    public function create(SysUserContext $sysUserContext, $data);

    /**
     * 更新客户资料
     * @param SysUserContext $sysUserContext
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update(SysUserContext $sysUserContext, $id, $data);

    /**
     * 修改备注和经营经验
     * @param $data
     * @return mixed
     */
    public function mark($data);

    /**
     * 查询兴趣项目痕迹
     * @param $id
     * @return mixed
     */
    public function interest($id);

    /**
     * 新增访问
     * @return mixed
     */
    public function visitPost(SysUserContext $sysUserContext, $data);

    /**
     * 查询回访记录
     * @param SysUserContext $sysUserContext
     * @param $offset
     * @param $size
     * @return mixed
     */
    public function visitLists(SysUserContext $sysUserContext, $search, $offset, $size);

    
}