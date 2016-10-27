<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/10/27
 * Time: 14:17
 */

namespace App\Http\Repositories\Daos\Impls;


use App\Http\Repositories\Daos\IMenuPermissionDao;
use App\Http\Repositories\Eloquent\MenuPermission;

class MenuPermissionDao extends BaseDao implements IMenuPermissionDao
{

    public function __construct(MenuPermission $model)
    {
        parent::__construct($model);
    }

    public function findMenuByRoleId($roleId) {

        $this->query->where('user_role_id','=', $roleId);

        $this->query->select('menu_id');

        return $this->query->get();

    }

}