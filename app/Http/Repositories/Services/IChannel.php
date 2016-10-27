<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/10/8
 * Time: 13:13
 */

namespace App\Http\Repositories\Services;

use App\Http\Requests\SysUserContext;

interface IChannel
{

    /**
     * 返回我能够查询到的渠道列表
     * @param SysUserContext $sysUserContext
     * @return mixed
     */
    public function getMyChannel(SysUserContext $sysUserContext);

}