<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/10/9
 * Time: 16:42
 */

namespace App\Http\Repositories\Daos\Impls;

use App\Http\Repositories\Daos\ICustomerDao;
use App\Http\Repositories\Eloquent\Customer;

class CustomerDao extends BaseDao implements ICustomerDao
{

    public function __construct(Customer $model)
    {
        parent::__construct($model);
    }

    public function findCustomer($search, $offset, $size)
    {
        //'merchantId','groupId','name','mobile','qq','weixin','provinceId','cityId','areaId','level','channelId','isAssigned', 'isVisited'
        if (isset($search['merchantId']) && !empty($search['merchantId'])) {
            $this->query->where('merchant_id','=', $search['merchantId']);
        }
        if (isset($search['groupId']) && !empty($search['groupId'])) {
            $this->query->where('group_id','=', $search['groupId']);
        }
        if (isset($search['userId']) && !empty($search['userId'])) {
            $this->query->where('user_id','=', $search['userId']);
        }
        if (isset($search['name']) && !empty($search['name'])) {
            $this->query->where('name','like', '%'.$search['name'].'%');
        }
        if (isset($search['mobile']) && !empty($search['mobile'])) {
            $this->query->where('mobile','=', $search['mobile']);
        }
        if (isset($search['qq']) && !empty($search['qq'])) {
            $this->query->where('qq','=', $search['qq']);
        }
        if (isset($search['weixin']) && !empty($search['weixin'])) {
            $this->query->where('weixin','=', $search['weixin']);
        }
        if (isset($search['provinceId']) && !empty($search['provinceId'])) {
            $this->query->where('province_id','=', $search['provinceId']);
        }
        if (isset($search['cityId']) && !empty($search['cityId'])) {
            $this->query->where('city_id','=', $search['cityId']);
        }
        if (isset($search['areaId']) && !empty($search['areaId'])) {
            $this->query->where('area_id','=', $search['areaId']);
        }
        if (isset($search['level']) && !empty($search['level'])) {
            $this->query->where('level','=', $search['level']);
        }
        if (isset($search['channelId']) && !empty($search['channelId'])) {
            $this->query->where('channel_id','=', $search['channelId']);
        }
        if (isset($search['isAssigned'])) {
            if ($search['isAssigned'] > 0) {
                $this->query->where('user_id','>', 0);
            } else {
                $this->query->where('user_id','=', 0);
            }
        }
        if (isset($search['isVisited'])) {
            $this->query->where('is_visited','=', intval($search['isVisited']));
        }
        $data = $this->page($offset, $size);
        return $data;
    }

}