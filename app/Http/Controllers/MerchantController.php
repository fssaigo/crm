<?php

namespace App\Http\Controllers;

use App\Http\Repositories\Services\IMerchant;
use Illuminate\Http\Request;
use App\Http\Requests\SysUserContext;
use App\Http\Requests;

class MerchantController extends Controller
{
    protected $merchantService;

    public function __construct(IMerchant $merchantService)
    {
        $this->middleware('authSession');
        $this->merchantService = $merchantService;
    }

    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $data = $this->merchantService->findMerchantById($id);
        return response()->json($data);
    }

    public function update(SysUserContext $sysUserContext, Request $request, $id)
    {
        $input = $request->only('userId', 'name', 'contacter', 'mobile','assigner','deleted');
        $this->merchantService->editMerchant($sysUserContext, $input, $id);
        return response()->json(['result' => true]);
    }

}
