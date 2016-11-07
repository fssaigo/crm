<?php
/**
 * Created by PhpStorm.
 * User: Huyang
* Date: 2016/9/5
* Time: 16:57
*/

namespace App\Http\Constants;

/**
 * 报错信息业务分段
 * Class BaseExceptionConstant
 * @package App\Http\Constants
 */
class ServiceExceptionConstants extends BaseExceptionConstants
{

    public static function code() {
        return $code = [
            'merchant_match_fail'=>      ['code'=>'1', 'message'=>'商户匹配失败'],
            'mobile_exits'=>             ['code'=>'2', 'message'=>'手机号码已经存在'],
            'login_fail'=>               ['code'=>'3', 'message'=>'用户名或者密码不正确'],
            'user_no_merchant'=>         ['code'=>'4', 'message'=>'该用户不属于任何商户'],
            'pond_was_assigned'=>        ['code'=>'4', 'message'=>'该数据已分配'],
            'user_no_role'=>             ['code'=>'5', 'message'=>'未知的角色'],
            'password_auth_filed'=>      ['code'=>'6', 'message'=>'原始密码验证失败'],
        ];
    }

    public static function getKey($key) {

        $top = self::getTopCode('SERVICE_EXCEPTION_START_CODE');

        $base = self::code()[$key];

        $base['code'] = $top .$base['code'];

        return $base;
    }

}


