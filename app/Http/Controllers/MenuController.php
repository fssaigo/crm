<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/10/20
 * Time: 15:07
 */

namespace App\Http\Controllers;


use App\Http\Repositories\Services\IMenu;
use App\Http\Requests\SysUserContext;

class MenuController extends Controller
{

    protected $menuService;

    public function __construct(IMenu $menuService)
    {
        $this->menuService = $menuService;
    }

    public function index(SysUserContext $sysUserContext) {

        $data = $this->menuService->nav($sysUserContext);

        return response()->json($data);
    }
}