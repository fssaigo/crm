<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/9/19
 * Time: 17:50
 */

namespace App\Http\Constants;


class BaseExceptionConstants
{

    public static function getTopCode($key) {
        return self::base()[$key];
    }

    public static function base() {
        return [
            'COMMON_EXCEPTION_START_CODE' => '10000',//公共错误code开始
            'SERVICE_EXCEPTION_START_CODE' => '20000',//Service级别的错误
            'MODEL_EXCEPTION_START_CODE' => '30000', //Model级别的错误
            'JWT_EXCEPTION_START_CODE' => '40000' //JWT级别的错误
        ];
    }

}