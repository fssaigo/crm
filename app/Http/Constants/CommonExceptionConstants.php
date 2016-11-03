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
class CommonExceptionConstants extends BaseExceptionConstants
{

    public static function code() {
        return $code = [
            'not_available_data'=>      ['code'=>'1', 'message'=>'无效的传入参数'],
            'no_find_data'=>            ['code'=>'2', 'message'=>'数据不存在'],
            'no_login'=>                ['code'=>'3', 'message'=>'需要登录后才能访问'],
            'no_data_permission'=>      ['code'=>'4', 'message'=>'没有数据操作权限'],
            'read_file_error'=>         ['code'=>'5', 'message'=>'读取文件错误'],
            'beyond_image_max_size'=>   ['code'=>'6', 'message'=>'超过文件最大限制'],
            'not_image'=>               ['code'=>'7', 'message'=>'此文件不是图片文件'],
            'ip_local_error'=>          ['code'=>'8', 'message'=>'图片格式不支持'],
            'no_jurisdiction'=>         ['code'=>'9', 'message'=>'没有权限操作'],
            'no_sys_address_info'=>     ['code'=>'10', 'message'=>'没有找到地址编码信息'],
            'upload_image_failed'=>     ['code'=>'11', 'message'=>'图片文件上传失败'],
            'repeat_name_error'=>       ['code'=>'12', 'message'=>'重复的名称'],
            'data_update_failed'=>      ['code'=>'13', 'message'=>'数据更新失败'],
            'data_save_failed'=>        ['code'=>'14', 'message'=>'数据保存失败'],
            'no_data_updated'=>         ['code'=>'15', 'message'=>'未发现有数据被更新'],
            'repeat_email_error'=>      ['code'=>'16', 'message'=>'重复的邮箱名称'],
        ];
    }

    public static function getKey($key) {

        $top = self::getTopCode('COMMON_EXCEPTION_START_CODE');

        $base = self::code()[$key];

        $base['code'] = $top .$base['code'];

        return $base;
    }

}


