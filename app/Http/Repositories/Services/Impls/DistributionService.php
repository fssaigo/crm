<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/10/21
 * Time: 15:01
 */

namespace App\Http\Repositories\Services\Impls;


use App\Exceptions\ServiceException;
use App\Http\Constants\CommonExceptionConstants;
use App\Http\Repositories\Daos\ICustomerDao;
use App\Http\Repositories\Services\IDistribution;
use App\Http\Requests\SysUserContext;
use App\Util\Helper;

class DistributionService implements IDistribution
{

    protected $customerDao;

    public function __construct(ICustomerDao $customerDao)
    {
        $this->customerDao = $customerDao;
    }

    public function assignByCharge(SysUserContext $sysUserContext, $ids, $userId)
    {
        if (!Helper::isIds($ids)) {
            throw new ServiceException(CommonExceptionConstants::getKey('not_available_data'));
        }
        if (!intval($userId)) {
            throw new ServiceException(CommonExceptionConstants::getKey('not_available_data'));
        }
        $data = $this->customerDao->findByIds(explode(',',$ids));
        if ((bool)$data) {
            foreach ($data as $record) {
                if ($record['group_id'] == $sysUserContext->getGroupId()) {
                    $this->customerDao->update($record['id'], ['user_id'=>$userId]);
                }
            }
        }
    }



}