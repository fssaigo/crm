<?php

namespace App\Http\Controllers;

use App\Http\Repositories\Eloquent\China;
use App\Http\Repositories\Services\IChannel;
use App\Http\Repositories\Services\IMenu;
use App\Http\Repositories\Services\IGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Http\Requests\SysUserContext;

class HomeController extends Controller
{

    private $channelService;
    private $menuService;

    public function __construct(IChannel $channelService, IMenu $menuService, IGroup $groupService)
    {
        $this->middleware('authSession');
        $this->channelService = $channelService;
        $this->menuService = $menuService;
        $this->groupService = $groupService;
    }

    public function commonView(SysUserContext $sysUserContext)
    {
        $baseConstant = $this->common($sysUserContext);
        $baseConstant = json_encode($baseConstant);
        return view('home')->with('baseConstant',$baseConstant);
    }

    public function commonJson(SysUserContext $sysUserContext) {
        $baseConstant = $this->common($sysUserContext);
        return response()->json($baseConstant);
    }

    public function common(SysUserContext $sysUserContext) {
        $baseConstant = [];
        $baseConstant['sex'] = Config::get('constant.sex');
        $baseConstant['level'] = Config::get('constant.level');
        $baseConstant['invest'] = Config::get('constant.invest');
        $baseConstant['experience'] = Config::get('constant.experience');
        $baseConstant['role'] = Config::get('constant.user_role');
        $baseConstant['area'] = [];
        $baseConstant['channel'] = $this->channelService->getMyChannel($sysUserContext);
        $area = China::all();
        $province = $city = $district = [];
        foreach ($area as $record) {
            if ($record['area_level'] == 'province') {
                $arrTmp = [];
                $arrTmp['value'] = $record['province_code'];
                $arrTmp['label'] = $record['province_name'];
                $province[] = $arrTmp;
            }
            if ($record['area_level'] == 'city') {
                $arrTmp = [];
                $arrTmp['value'] = $record['city_code'];
                $arrTmp['label'] = $record['city_name'];
                $city[$record['province_code']][] = $arrTmp;
            }
            if ($record['area_level'] == 'district') {
                $arrTmp = [];
                $arrTmp['value'] = $record['district_code'];
                $arrTmp['label'] = $record['district_name'];
                $district[$record['city_code']][] = $arrTmp;
            }
        }
        foreach ($province as $key => $val) {
            if (isset($city[$val['value']])) {
                $arrTmp = $city[$val['value']];
                foreach ($arrTmp as $aKey => $aVal) {
                    if (isset($district[$aVal['value']])) {
                        $arrTmp[$aKey]['children'] = $district[$aVal['value']];
                    }
                }
                $province[$key]['children'] = $arrTmp;
            }
        }
        $baseConstant['menu'] = $this->menuService->nav($sysUserContext);
        $baseConstant['groups'] = $this->groupService->findByList([], 0, 100)['results'];
        $baseConstant['area'] = $province;
        return $baseConstant;
    }

    public function jwt(Request $request) {

    }
}