<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/10/18
 * Time: 11:01
 */

namespace App\Http\Controllers;


use App\Http\Repositories\Eloquent\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApiController extends Controller
{
    /*注册*/
    public function register(Request $request)
    {
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        User::create($input);
        return response()->json(['result'=>true]);
    }

    /*登陆*/
    public function login(Request $request)
    {

        $input = $request->all();

        if (!$token = JWTAuth::attempt($input)) {
            return response()->json(['result' => '邮箱或密码错误.']);
        }
        
        return response()->json(['result' => $token]);
    }

    /*获取用户信息*/
    public function get_user_details(Request $request)
    {
        $input = $request->all();
        $user = JWTAuth::toUser($input['token']);
        return response()->json(['result' => $user]);
    }

}