<?php

namespace App\Http\Controllers;

use App\Http\Repositories\Services\IUser;
use App\Http\Requests\SysUserContext;
use App\Http\Requests\UserCreateRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(IUser $userService)
    {
        $this->middleware('authSession');
        $this->userService = $userService;
    }

    /**
     * 可以查询当前商户下的其他用户
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $search = $request->only('merchantId','groupId','name','email','mobile');
        $offset = $request->get('offset');
        $size = $request->get('size');
        $data = $this->userService->findUserList($search, $offset, $size);
        return response()->json($data);
    }

    /**
     * 根据商户和小组来查询用户
     * @param $request
     * @param $merchantId
     * @param $groupId
     * @return mixed
     */
    public function findUserByMerchantGroup(Request $request, $merchantId, $groupId) {
        $search = $request->only('merchantId','groupId','name','email','mobile');
        if ($merchantId > 0) {
            $search['merchantId'] = $merchantId;
        }
        if ($groupId > 0) {
            $search['groupId'] = $groupId;
        }
        $offset = $request->get('offset');
        $size = $request->get('size');
        $data = $this->userService->findUserList($search, $offset, $size);
        $result = [];
        foreach ($data['results'] as $record) {
            $result[] = $record;
        }
        return response()->json($result);
    }

    /**
     * 用户模糊查询
     * @param SysUserContext $sysUserContext
     * @param Request $request
     * @return mixed
     */
    public function names(SysUserContext $sysUserContext, Request $request) {
        $name = $request->get('name');
        $data = $this->userService->findUserByName($sysUserContext->getMerchantId(), $name);
        return response()->json($data);
    }

    /**
     * @param SysUserContext $sysUserContext
     * @param UserCreateRequest $request
     * @return mixed
     */
    public function store(SysUserContext $sysUserContext, UserCreateRequest $request)
    {
        $input = $request->only('userRoleId','groupId', 'name', 'password', 'email', 'mobile');
        $id = $this->userService->saveUser($sysUserContext, $input);
        return response()->json(['id'=>$id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->userService->findByUserId($id);
        return response()->json($data);
    }

    /**
     * 更新用户资料
     * @param SysUserContext $sysUserContext
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(SysUserContext $sysUserContext, Request $request, $id)
    {
        $input = $request->only('userRoleId','groupId', 'name', 'password', 'mobile','deleted');
        $this->userService->editUser($sysUserContext, $input, $id);
        return response()->json(['result' => true]);
    }


    public function password(SysUserContext $sysUserContext, Request $request)
    {
        $input = $request->only('password','newPassword');
        $password = $input['password'];
        $newPassword = $input['newPassword'];
        $this->userService->password($sysUserContext, $password, $newPassword);
        return response()->json(['result' => true]);
    }

}
