<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/10/21
 * Time: 14:55
 */

namespace App\Http\Controllers;


use App\Http\Repositories\Services\IDistribution;
use App\Http\Requests\SysUserContext;
use Illuminate\Http\Request;

class DistributionController extends Controller
{

    protected $distributionService;

    public function __construct(IDistribution $distributionService)
    {
        $this->middleware('authSession');
        $this->distributionService = $distributionService;
    }

    public function store(SysUserContext $sysUserContext, Request $request) {
        $input = $request->only('ids', 'userId');
        $this->distributionService->assignByCharge($sysUserContext, $input['ids'], $input['userId']);
        return response()->json(['result' => true]);
    }


}