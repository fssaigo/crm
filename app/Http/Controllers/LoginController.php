<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/10/24
 * Time: 17:46
 */

namespace App\Http\Controllers;

use App\Http\Repositories\Services\IUser;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Http\Request;

class LoginController
{

        protected $userService;

        public function __construct(IUser $userService)
        {
                $this->userService = $userService;
                //$this->middleware('authSession', ['except' => ['login','show']]);
        }

        /**
         * 渲染登陆页面
         * @return mixed
         */
        public function show() {
                return view('login');
        }

        /**
         * 用户登录
         * @param UserLoginRequest $request
         * @return mixed
         */
        public function login(UserLoginRequest $request) {
                $input = $request->only('email', 'password');
                $data = $this->userService->login($input);
                return response()->json($data);
        }

        /**
         * 退出
         * @param Request $request
         * @return mixed
         */
        public function logout(Request $request) {
                $request->session()->flush();
                return redirect('/login');
        }

}