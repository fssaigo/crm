<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/10/8
 * Time: 17:23
 */

namespace App\Http\Repositories\Services\Impls;


use App\Exceptions\ServiceException;
use App\Http\Constants\CommonExceptionConstants;
use App\Http\Constants\ServiceExceptionConstants;
use App\Http\Repositories\Daos\ICustomerDao;
use App\Http\Repositories\Daos\ICustomerMarkDao;
use App\Http\Repositories\Daos\IPondDao;
use App\Http\Repositories\Services\IPond;
use App\Http\Requests\SysUserContext;
use App\Util\Helper;

class PondService implements IPond
{

    protected $pondDao;
    protected $customerDao;
    protected $customerMarkDao;

    public function __construct(IPondDao $pondDao, ICustomerDao $customerDao, ICustomerMarkDao $customerMarkDao)
    {
        $this->pondDao = $pondDao;
        $this->customerDao = $customerDao;
        $this->customerMarkDao = $customerMarkDao;
    }

    public function findPondList(SysUserContext $sysUserContext, $search, $offset, $size)
    {
        $data = $this->pondDao->findPond($search, $offset, $size);

        if ($data['totalCount'] > 0) {
            foreach ($data['results'] as $key => $record) {
                #$data['results'][$key]['created_at'] = date('Y-m-d H:i:s', $record['created_at']);
                #$data['results'][$key]['updated_at'] = date('Y-m-d H:i:s', $record['updated_at']);
            }
        }

        return $data;
    }

    public function pondAssigner(SysUserContext $sysUserContext, $ids, $groupId)
    {

        if (!Helper::isIds($ids)) {
            throw new ServiceException(CommonExceptionConstants::getKey('not_available_data'));
        }

        if (!intval($groupId)) {
            throw new ServiceException(CommonExceptionConstants::getKey('not_available_data'));
        }

        $data = $this->pondDao->findByIds(explode(',',$ids));

        $i = 0;

        if ((bool)$data) {

            foreach ($data as $record) {
                if ($record['customer_id'] == 0) {
                    $i++;
                    $customer = [];
                    $customer['merchant_id'] = $sysUserContext->getMerchantId();
                    $customer['group_id'] = $groupId;
                    $customer['user_id'] = 0;
                    $customer['name'] = $record['name'];
                    $customer['email'] = $record['email'];
                    $customer['weixin'] = '';
                    $customer['mobile'] = $record['mobile'];
                    $customer['qq'] = $record['qq'];
                    $obj = $this->customerDao->save($customer);
                    $mark = [];
                    $mark['experience'] = '';
                    $mark['mark'] = '';
                    if ((bool)$mark) {
                        $mark['customer_id'] = $obj->id;
                        $this->customerMarkDao->save($mark);
                    }
                    $pan = [];
                    $pan['group_id'] = $groupId;
                    $pan['customer_id'] = $obj->id;
                    $this->pondDao->update($record['id'], $pan);
                }
            }
        }

        if ($i == 0) {
            throw new ServiceException(ServiceExceptionConstants::getKey('pond_was_assigned'));
        }

    }

}