<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/9/28
 * Time: 14:36
 */

namespace App\Http\Repositories\Services;


use App\Http\Requests\SysUserContext;

interface IUser
{

    /**
     * 查询单个用户信息
     * @param $id
     * @return mixed
     */
    public function findByUserId($id);

    /**
     * 根据用户姓名来查询用户
     * @param $merchantId
     * @param $name
     * @return mixed
     */
    public function findUserByName($merchantId, $name);

    /**
     * 查询用户
     * @param $search
     * @param $offset
     * @param $size
     * @return mixed
     */
    public function findUserList($search, $offset, $size);

    /**
     * 新增用户
     * @param SysUserContext $sysUserContext
     * @param $input
     * @return mixed
     */
    public function saveUser(SysUserContext $sysUserContext, $input);

    /**
     * 更新用户
     * @param SysUserContext $sysUserContext
     * @param $input
     * @param $id
     * @return mixed
     */
    public function editUser(SysUserContext $sysUserContext, $input, $id);

    /**
     * 发送邮件
     * @param $input
     * @return mixed
     */
    public function sendEmail($input);

    /**
     * @param SysUserContext $sysUserContext
     * @param $userId
     * @param $userRoleId
     * @return mixed
     */
    public function setRole(SysUserContext $sysUserContext, $userId, $userRoleId);

    public function password(SysUserContext $sysUserContext, $password, $newPassword);

    /**
     * 发送短信
     * @param $input
     * @return mixed
     */
    public function sendMsg($input);

    /**
     * @param $input
     * @return mixed
     */
    public function Login($input);

}