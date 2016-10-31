<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/9/20
 * Time: 18:10
 */

namespace App\Http\Repositories\Daos\Impls;

use App\Http\Repositories\Daos\IMerchantDao;
use App\Http\Repositories\Eloquent\Merchant;

class MerchantDao extends BaseDao implements IMerchantDao
{

    public function __construct(Merchant $model)
    {
        parent::__construct($model);
    }
    public function findMerchant($search, $offset, $size) {
        if (isset($search['merchant_id']) && $search['merchant_id'] > 0) {
            $this->query->where('merchant_id','=', $search['merchant_id']);
        }
        if (isset($search['group_id']) && $search['group_id'] > 0) {
            $this->query->where('group_id','=', $search['group_id']);
        }
        if (isset($search['name']) && !empty($search['name'])) {
            $this->query->where('name','=', $search['name']);
        }
        if (isset($search['mobile']) && $search['mobile']) {
            $this->query->where('mobile','=', $search['mobile']);
        }
        if (isset($search['email']) && !empty($search['email'])) {
            $this->query->where('mobile','=', $search['mobile']);
        }
        $this->query->select('id','merchant_id','group_id','name','email','mobile','is_deleted','created_at','updated_at');
        return $this->page($offset, $size);
    }
}
