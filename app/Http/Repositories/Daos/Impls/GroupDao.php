<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/9/18
 * Time: 15:26
 */

namespace App\Http\Repositories\Daos\Impls;

use App\Http\Repositories\Daos\IGroupDao;
use App\Http\Repositories\Eloquent\Group;


class GroupDao extends BaseDao implements IGroupDao
{

    public function __construct(Group $model)
    {
        parent::__construct($model);
    }

    public function findByName($name)
    {
        $data = $this->model->where('name', '=', $name)->get()->first();
        if ($data) {
            return $data->toArray();
        } else {
            return false;
        }
    }

    public function findGroup($search, $offset, $size) {
        if (isset($search['merchantId']) && $search['merchantId'] > 0) {
            $this->query->where('merchant_id','=', $search['merchantId']);
        }
        if (isset($search['name']) && !empty($search['name'])) {
            $this->query->where('name','like', '%'.$search['name'].'%');
        }
        $this->query->select('id','user_id','merchant_id','name','is_deleted','created_at','updated_at');
        return $this->page($offset, $size);
    }
}