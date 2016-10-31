<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/9/22
 * Time: 9:52
 */

namespace App\Http\Repositories\Services;


use App\Http\Requests\SysUserContext;

interface IMerchant
{

    public function findMerchantById($id);

    /**
     * 返回商户的负责人
     * @param $merchantId
     * @return mixed
     */
    public function getMerchantUserId($merchantId);

    /**
     * 查询所有商户
     * @param $search
     * @param $offset
     * @param $size
     * @return mixed
     */
    public function findMerchantList($search, $offset, $size);

    /**
     * 更新商户信息
     * @param SysUserContext $sysUserContext
     * @param $input
     * @param $id
     * @return mixed
     */
    public function editMerchant(SysUserContext $sysUserContext, $input, $id);

}