<?php

namespace App\Http\Controllers;

use App\Http\Repositories\Services\ICustomer;
use Illuminate\Http\Request;
use App\Http\Requests\SysUserContext;

use App\Http\Requests;

class CustomerController extends Controller
{

    private $customerService;

    public function __construct(ICustomer $customerService)
    {
        $this->middleware('authSession');
        $this->customerService = $customerService;
    }

    public function getSearchFilter() {
        return ['merchantId','groupId','userId','name','mobile','qq','weixin','provinceId','cityId','areaId','level','channelId','isAssigned', 'isVisited'];
    }
    public function getCUFilter() {
        return ['groupId', 'userId','name','assist','sex','email','wx','mobile','qq','area','invest','level','enter','manage','sent','visit','reception','intention','official', 'channel','nextVisitTime','pay','experience','mark'];
    }

    public function index(SysUserContext $sysUserContext, Request $request)
    {
        $search = $request->only($this->getSearchFilter());
        $offset = $request->get('offset');
        $size = $request->get('size');
        $data = $this->customerService->lists($sysUserContext, $search, $offset, $size);
        return response()->json($data);
    }
    
    public function customersByUserId(SysUserContext $sysUserContext, Request $request)
    {
        $search = $request->only($this->getSearchFilter());
        $search['userId'] = $sysUserContext->getId();
        $offset = $request->get('offset');
        $size = $request->get('size');
        $data = $this->customerService->lists($sysUserContext, $search, $offset, $size);
        return response()->json($data);
    }

    public function customersByGroupId(SysUserContext $sysUserContext, Request $request)
    {
        $search = $request->only($this->getSearchFilter());
        $search['merchantId'] = $sysUserContext->getMerchantId();
        $search['groupId'] = $sysUserContext->getGroupId();
        $offset = $request->get('offset');
        $size = $request->get('size');
        $data = $this->customerService->lists($sysUserContext, $search, $offset, $size);
        return response()->json($data);
    }

    public function customersByMerchantId(SysUserContext $sysUserContext, Request $request)
    {
        $search = $request->only($this->getSearchFilter());
        $search['merchantId'] = $sysUserContext->getMerchantId();
        $offset = $request->get('offset');
        $size = $request->get('size');
        $data = $this->customerService->lists($sysUserContext, $search, $offset, $size);
        return response()->json($data);
    }

    public function show($id) {
        $data = $this->customerService->findById($id);
        return response()->json($data);
    }

    public function store(SysUserContext $sysUserContext, Request $request)
    {
        $data = $request->only($this->getCUFilter());
        $customerId = $this->customerService->create($sysUserContext, $data);
        return response()->json(['id' => $customerId]);
    }

    public function update(SysUserContext $sysUserContext, Request $request, $id)
    {
        $data = $request->only($this->getCUFilter());
        $this->customerService->update($sysUserContext, $id, $data);
        return response()->json(['result' => true]);
    }

    public function visit(SysUserContext $sysUserContext,Request $request) {
        $input = $request->only('customerId','nextVisitTime','mark');
        $data = $this->customerService->visitPost($sysUserContext, $input);
        return response()->json($data);
    }

    public function visits(SysUserContext $sysUserContext, Request $request)
    {
        $search = $request->only('customerId');
        $offset = $request->get('offset');
        $size = $request->get('size');
        $data = $this->customerService->visitLists($sysUserContext, $search, $offset, $size);
        return response()->json($data);
    }

}
