<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/9/28
 * Time: 14:56
 */

namespace App\Http\Repositories\Daos\Impls;


use App\Http\Repositories\Daos\IUserDao;
use App\Http\Repositories\Eloquent\User;

class UserDao extends BaseDao implements IUserDao
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function findUserByName($merchantId, $name) {
        $this->query->where('merchant_id','=', $merchantId);
        $this->query->where('name', 'like', '%'.$name.'%');
        $this->query->select('id','name');
        $data = $this->query->get();
        return $data->toArray();
    }

    public function findUser($search, $offset, $size)
    {
        if (isset($search['merchantId']) && $search['merchantId'] > 0) {
            $this->query->where('merchant_id','=', $search['merchantId']);
        }
        if (isset($search['groupId']) && $search['groupId'] > 0) {
            $this->query->where('group_id','=', $search['groupId']);
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

    public function test() {
        echo 'hell';
    }

    public function findByEmail($email)
    {
        $data = $this->model->where('email', '=', $email)->get()->first();
        if ($data) {
            return $data;
        } else {
            return false;
        }
    }


}