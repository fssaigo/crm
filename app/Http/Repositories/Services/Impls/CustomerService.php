<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/10/11
 * Time: 14:34
 */

namespace App\Http\Repositories\Services\Impls;

use App\Exceptions\ServiceException;
use App\Http\Constants\CommonExceptionConstants;
use App\Http\Constants\ServiceExceptionConstants;
use App\Http\Repositories\Daos\IChannelDao;
use App\Http\Repositories\Daos\IChinaDao;
use App\Http\Repositories\Daos\ICustomerDao;
use App\Http\Repositories\Daos\ICustomerMarkDao;
use App\Http\Repositories\Daos\ICustomerVisitDao;
use App\Http\Repositories\Daos\IGroupDao;
use App\Http\Repositories\Daos\IUserDao;
use App\Http\Repositories\Eloquent\Customer;
use App\Http\Repositories\Services\ICustomer;
use App\Http\Requests\SysUserContext;
use App\Util\Helper;

class CustomerService implements ICustomer
{

    protected $customerDao;
    protected $customerMarkDao;
    protected $customerVisitDao;
    protected $channelDao;
    protected $groupDao;
    protected $userDao;
    protected $chinaDao;

    public function __construct(ICustomerDao $customerDao, ICustomerMarkDao $customerMarkDao, ICustomerVisitDao $customerVisitDao, IChannelDao $channelDao, IGroupDao $groupDao, IUserDao $userDao, IChinaDao $chinaDao)
    {
        $this->customerDao = $customerDao;
        $this->customerMarkDao = $customerMarkDao;
        $this->customerVisitDao = $customerVisitDao;
        $this->channelDao = $channelDao;
        $this->groupDao = $groupDao;
        $this->userDao = $userDao;
        $this->chinaDao = $chinaDao;
    }

    public function findById($id) {
        if ($customer = $this->customerDao->findOne($id)) {
            if ($mark = $this->customerMarkDao->findByCustomerId($customer->id)) {
                $customer = $customer->toArray();
                $mark = $mark->toArray();
                unset($mark['id']);
                unset($mark['created_at']);
                unset($mark['updated_at']);
                $result = array_merge($customer, $mark);
            } else {
                $result = $customer;
            }
            return $result;
        } else {
            throw new ServiceException(CommonExceptionConstants::getKey('no_find_data'));
        }
    }

    public function lists(SysUserContext $sysUserContext, $search, $offset, $size)
    {

        if ($sysUserContext->getIsLeader()) {
            $search['merchantId'] = $sysUserContext->getMerchantId();
        }
        if ($sysUserContext->getIsCharge()) {
            $search['groupId'] = $sysUserContext->getGroupId();
        }
        if ($sysUserContext->getIsSale()) {
            $search['userId'] = $sysUserContext->getId();
        }
        if ($sysUserContext->getIsDistribution()) {
            $search['userId'] = 0;
        }

        $data = $this->customerDao->findCustomer($search, $offset, $size);

        $groupIds = Helper::returnArrayVal($data['results'], 'group_id');
        $channelIds = Helper::returnArrayVal($data['results'], 'channel_id');
        $userIds = Helper::returnArrayVal($data['results'], 'user_id', 'assist_id', 'reception_id', 'creator_id');

        $provinceIds = Helper::returnArrayVal($data['results'], 'province_id');
        $cityIds = Helper::returnArrayVal($data['results'], 'city_id');
        $districtIds = Helper::returnArrayVal($data['results'], 'area_id');
        $customerIds = Helper::returnArrayVal($data['results'], 'id');

        $provinceList = $this->chinaDao->province($provinceIds);
        $cityList = $this->chinaDao->city($cityIds);
        $districtList = $this->chinaDao->district($districtIds);

        $groupList = $this->groupDao->findMapByIds($groupIds, 'name');
        $channelList = $this->channelDao->findMapByIds($channelIds, 'name');
        $userList = $this->userDao->findMapByIds($userIds, 'name');
        $markList = $this->customerMarkDao->findByKeyInVal('customer_id',$customerIds, 'mark');

        /**
         * 数据映射
         */
        foreach ($data['results'] as $key => $val) {
            $data['results'][$key]['group_name'] = $groupList[$val['group_id']];
            $data['results'][$key]['channel_name'] = $channelList[$val['channel_id']];
            $data['results'][$key]['user_name'] = $userList[$val['user_id']];
            $data['results'][$key]['assist_name'] = $userList[$val['assist_id']];
            $data['results'][$key]['reception_name'] = $userList[$val['reception_id']];
            $data['results'][$key]['creator_name'] = $userList[$val['creator_id']];
            $mark = array_get($markList, $val['id']);
            $data['results'][$key]['mark'] = $mark['mark'];

            $data['results'][$key]['province_name'] = $provinceList[$val['province_id']];
            $data['results'][$key]['city_name'] = $cityList[$val['city_id']];
            $data['results'][$key]['area_name'] = $districtList[$val['area_id']];
            #$data['results'][$key]['created_at'] = date('Y-m-d H:i:s', $val['created_at']);
            #$data['results'][$key]['updated_at'] = date('Y-m-d H:i:s', $val['updated_at']);
        }

        return $data;

    }

    public function create(SysUserContext $sysUserContext, $input)
    {
        if (!$sysUserContext->getIsLeader() && !$sysUserContext->getIsSale() && !$sysUserContext->getIsCharge()) {
            throw new ServiceException(CommonExceptionConstants::getKey('no_data_permission'));
        }

        $data = [];
        $data['merchant_id'] = $sysUserContext->getMerchantId();
        $data['group_id'] = intval($input['groupId']);
        $data['user_id'] = intval($input['userId']);
        $data['assist_id'] = intval($input['assist']);
        $data['name'] = trim($input['name']);
        $data['sex'] = intval($input['sex']);
        $data['email'] = trim($input['email']);
        $data['weixin'] = trim($input['wx']);
        $data['mobile'] = trim($input['mobile']);
        $data['qq'] = trim($input['qq']);
        $data['province_id'] = intval($input['area'][0]);
        $data['city_id'] = intval($input['area'][1]);
        $data['area_id'] = intval($input['area'][2]);
        $data['invest'] = intval($input['invest']);
        $data['level'] = intval($input['level']);
        $data['is_entered'] = intval($input['enter']);
        $data['is_managed'] = intval($input['manage']);
        $data['is_sent'] = intval($input['sent']);
        $data['is_visited'] = intval($input['visit']);
        $data['reception_id'] = intval($input['reception']);
        $data['is_signed_intention'] = intval($input['intention']);
        $data['is_signed_official'] = intval($input['official']);
        $data['is_paid'] = intval($input['pay']);
        $data['is_shared'] = 0;
        $data['channel_id'] = intval($input['channel']);
        $data['pand_id'] = 0;
        $data['assigner'] = 0;
        $data['creator_id'] = $sysUserContext->getId();


        if ($this->isExitsMobile($data['mobile'], $sysUserContext->getMerchantId())) {
            throw new ServiceException(ServiceExceptionConstants::getKey('mobile_exits'));
        }

        $customer = $this->customerDao->save($data);

        if ($customer) {
            $mark = [];
            $mark['customer_id'] = $customer->id;
            $mark['experience'] = trim($input['experience']);
            $mark['mark'] = trim($input['mark']);
            $this->mark($mark);
            return $customer->id;
        } else {
            throw new ServiceException(CommonExceptionConstants::getKey('data_save_failed'));
        }
    }

    public function update(SysUserContext $sysUserContext, $id, $input)
    {
        if (!$sysUserContext->getIsLeader() && !$sysUserContext->getIsSale() && !$sysUserContext->getIsCharge()) {
            throw new ServiceException(CommonExceptionConstants::getKey('no_data_permission'));
        }

        $data = [];
        $data['name'] = $input['name'];
        $data['group_id'] = $input['groupId'];
        $data['user_id'] = $input['userId'];
        $data['assist_id'] = $input['assist'];
        $data['sex'] = $input['sex'];
        $data['email'] = $input['email'];
        $data['weixin'] = $input['wx'];
        $data['mobile'] = $input['mobile'];
        $data['qq'] = $input['qq'];
        $data['province_id'] = $input['area'][0];
        $data['city_id'] = $input['area'][1];
        $data['area_id'] = $input['area'][2];
        $data['invest'] = $input['invest'];
        $data['level'] = $input['level'];
        $data['is_entered'] = $input['enter'];
        $data['is_managed'] = $input['manage'];
        $data['is_sent'] = $input['sent'];
        $data['is_visited'] = $input['visit'];
        $data['next_visit_time'] = $input['nextVisitTime'];
        $data['reception_id'] = $input['reception'];
        $data['is_signed_intention'] = $input['intention'];
        $data['is_signed_official'] = $input['official'];
        $data['is_paid'] = $input['pay'];
        $data['channel_id'] = $input['channel'];

        $data = Helper::removeNull($data);

        if (isset($data['mobile'])) {
            if ($this->isExitsMobile($data['mobile'], $sysUserContext->getMerchantId(), $id)) {
                throw new ServiceException(ServiceExceptionConstants::getKey('mobile_exits'));
            }
        }

        if ($this->customerDao->update($id, $data)) {
            $mark = [];
            $mark['experience'] = $input['experience'];
            $mark['mark'] = $input['mark'];
            $mark = Helper::removeNull($mark);
            if ((bool)$mark) {
                $mark['customer_id'] = $id;
                $this->mark($mark);
            }
        } else {
            throw new ServiceException(CommonExceptionConstants::getKey('data_save_failed'));
        }
        
    }

    public function isExitsMobile($mobile, $merchantId = 0, $id = 0) {
        if (!empty($mobile)) {
            if ($id) {
                return Customer::where('mobile','=',$mobile)->where('merchant_id','=',$merchantId)->where('id','!=', $id)->count();
            } else {
                return Customer::where('mobile','=',$mobile)->where('merchant_id','=',$merchantId)->count();
            }
        } else {
            return 0;
        }
    }

    public function mark($data)
    {
        if ($result = $this->customerMarkDao->findByCustomerId($data['customer_id'])) {
            $this->customerMarkDao->update($result['id'], $data);
        } else {
            $this->customerMarkDao->save($data);
        }
    }

    public function interest($id)
    {
        // TODO: Implement interest() method.
    }

    public function visitPost(SysUserContext $sysUserContext, $input)
    {

        if (!$sysUserContext->getIsLeader() && !$sysUserContext->getIsSale() && !$sysUserContext->getIsCharge()) {
            throw new ServiceException(CommonExceptionConstants::getKey('no_data_permission'));
        }

        $data = [];
        $data['user_id'] = $sysUserContext->getId();
        $data['customer_id'] = intval($input['customerId']);
        $data['next_visit_time'] = trim($input['nextVisitTime']);
        $data['mark'] = trim($input['mark']);

        $visit = $this->customerVisitDao->save($data);

        if ($visit) {
            if ($data['next_visit_time']) {
                $visitTime = ['next_visit_time'=>$data['next_visit_time']];
                $this->customerDao->update($data['customer_id'], $visitTime);
            }
            $result = $visit->toArray();
            #$result['created_at'] = date('Y-m-d H:i:s', $result['created_at']);
            #$result['updated_at'] = date('Y-m-d H:i:s', $result['updated_at']);
            $result['user_name'] = $sysUserContext->getUserName();
            return $result;
        } else {
            throw new ServiceException(CommonExceptionConstants::getKey('data_save_failed'));
        }

    }

    public function visitLists(SysUserContext $sysUserContext, $search, $offset, $size)
    {
        $data = $this->customerVisitDao->visits($search,$offset, $size);
        $userIds = Helper::returnArrayVal($data['results'], 'user_id');
        $userList = $this->userDao->findMapByIds($userIds, 'name');
        foreach ($data['results'] as $key => $val) {
            $data['results'][$key]['user_name'] = $userList[$val['user_id']];
            #$data['results'][$key]['created_at'] = date('Y-m-d H:i:s', $val['created_at']);
            #$data['results'][$key]['updated_at'] = date('Y-m-d H:i:s', $val['updated_at']);
        }
        return $data;
    }

}