<?php

namespace App\Http\Controllers;

use App\Http\Repositories\Services\IGroup;
use App\Http\Requests\GroupCreateRequest;
use App\Http\Requests\SysUserContext;
use Illuminate\Http\Request;

class GroupController extends Controller
{

    private $groupService;

    public function __construct(IGroup $groupService)
    {
        $this->middleware('authSession');
        $this->groupService = $groupService;
    }

    /**
     * 渲染列表
     * @param SysUserContext $sysUserContext
     * @param Request $request
     * @return mixed
     */
    public function index(SysUserContext $sysUserContext, Request $request)
    {
        $search = $request->only('name');
        $search['merchantId'] = $sysUserContext->getMerchantId();
        $offset = $request->get('offset');
        $size = $request->get('size');
        $data = $this->groupService->findByList($search, $offset, $size);
        return response()->json($data);
    }

    /**
     * @param SysUserContext $sysUserContext
     * @param GroupCreateRequest $request
     * @return mixed
     */
    public function store(SysUserContext $sysUserContext, GroupCreateRequest $request)
    {
        $input = $request->only('userId', 'name');
        $this->groupService->saveGroup($sysUserContext, $input);
        return response()->json(['result' => true]);
    }

    /**
     * Display the specified resource.
     * 展示单个信息
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->groupService->findById($id);
        return response()->json($data);
    }

    /**
     * @param SysUserContext $sysUserContext
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(SysUserContext $sysUserContext, Request $request, $id)
    {
        $input = $request->only('userId', 'name');
        $this->groupService->editGroup($sysUserContext, $input, $id);
        return response()->json(['result' => true]);
    }

}
