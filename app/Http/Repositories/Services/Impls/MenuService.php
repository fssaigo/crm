<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/10/20
 * Time: 14:58
 */

namespace App\Http\Repositories\Services\Impls;


use App\Http\Repositories\Daos\IMenuDao;
use App\Http\Repositories\Daos\IMenuPermissionDao;
use App\Http\Repositories\Services\IMenu;
use App\Http\Requests\SysUserContext;
use App\Util\Helper;

class MenuService implements IMenu
{

    protected $menuDao;

    protected $menuPermissionDao;

    public function __construct(IMenuDao $menuDao, IMenuPermissionDao $menuPermissionDao)
    {
        $this->menuDao = $menuDao;
        $this->menuPermissionDao = $menuPermissionDao;
    }

    public function nav(SysUserContext $sysUserContext)
    {
        $result = $this->menuDao->nav();
        $menu = $this->menuPermissionDao->findMenuByRoleId($sysUserContext->getRoleId());
        $menuId = [];
        foreach ($menu as $record) {
            $menuId[$record['menu_id']] = $record['menu_id'];
        }
        foreach ($result['results'] as $key => $record) {
            if (!in_array($record['id'], $menuId)) {
                unset($result['results'][$key]);
            }
        }
        $output = [];
        Helper::refactorNoKey('id', $result['results'], $output);
        return $output;
    }

}