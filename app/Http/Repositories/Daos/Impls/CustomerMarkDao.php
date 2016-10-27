<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/10/10
 * Time: 11:37
 */

namespace App\Http\Repositories\Daos\Impls;


use App\Http\Repositories\Daos\ICustomerMarkDao;
use App\Http\Repositories\Eloquent\CustomerMark;

class CustomerMarkDao extends BaseDao implements ICustomerMarkDao
{

    public function __construct(CustomerMark $model)
    {
        parent::__construct($model);
    }

    public function findByCustomerId($customerId)
    {
        if ($data = $this->model->where('customer_id', '=', $customerId)->get()->first()) {
            return $data;
        } else {
            return false;
        }
    }


}