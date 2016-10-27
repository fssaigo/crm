<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/10/14
 * Time: 16:28
 */

namespace App\Http\Repositories\Daos\Impls;


use App\Http\Repositories\Daos\ICustomerVisitDao;
use App\Http\Repositories\Eloquent\CustomerVisit;

class CustomerVisitDao extends BaseDao implements ICustomerVisitDao
{

    public function __construct(CustomerVisit $model)
    {
        parent::__construct($model);
    }

    public function visits($search, $offset, $size) {
        if (isset($search['customerId']) && $search['customerId'] > 0) {
            $this->query->where('customer_id','=', $search['customerId']);
        }
        return $this->page($offset, $size);
    }

}