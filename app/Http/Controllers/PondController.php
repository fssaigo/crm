<?php

namespace App\Http\Controllers;

use App\Http\Repositories\Services\IPond;
use Illuminate\Http\Request;
use App\Http\Requests\SysUserContext;

use App\Http\Requests;

class PondController extends Controller
{
    protected $pondService;

    public function __construct(IPond $pondService)
    {
        $this->middleware('authSession');
        $this->pondService = $pondService;
    }

    public function index(SysUserContext $sysUserContext, Request $request)
    {
        $search = $request->only('channelId','groupId','isDistribution','bgnTime','endTime');
        $offset = $request->get('offset');
        $size = $request->get('size');
        $data = $this->pondService->findPondList($sysUserContext, $search, $offset, $size);
        return response()->json($data);
    }

    public function assign(SysUserContext $sysUserContext, Request $request) {
        $ids = $request->get('ids');
        $groupId = $request->get('groupId');
        $this->pondService->pondAssigner($sysUserContext, $ids, $groupId);
        return response()->json(['result' => true]);
    }

}
