<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/10/20
 * Time: 14:55
 */

namespace App\Http\Repositories\Daos\Impls;


use App\Http\Repositories\Daos\IMenuDao;
use App\Http\Repositories\Eloquent\Menu;

class MenuDao extends BaseDao implements IMenuDao
{

    public function __construct(Menu $model)
    {
        parent::__construct($model);
    }

    public function nav()
    {
        $this->query->select('id','parent_id','title','icon','url');
        return $this->page(0, 100000, ['sort' => 'asc','id' => 'asc']);
    }

}