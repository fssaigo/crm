<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/9/21
 * Time: 18:01
 */

namespace App\Http\Repositories\Eloquent;

use Eloquent;

class Orm extends Eloquent
{

    /**
     * 黑名单
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * 隐藏字段
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * 默认使用时间戳戳功能
     *
     * @var bool
     */
    public $timestamps = true;

    protected $dates = ['created_at', 'updated_at', 'disabled_at'];

    /**
     * 获取当前时间
     *
     * @return int
     */
    public function freshTimestamp() {
        return time();
    }

    /**
     * 避免转换时间戳为时间字符串
     *
     * @param DateTime|int $value
     * @return DateTime|int
     */
    public function fromDateTime($value) {
        return $value;
    }

    /**
     * 从数据库获取的为获取时间戳格式
     *
     * @return string
     */
    public function getDateFormat() {
        return 'U';
    }

    public function getCreatedAtAttribute(){
        return date('Y-m-d H:i:s',$this->attributes['created_at']);
    }
    public function getUpdatedAtAttribute(){
        return date('Y-m-d H:i:s',$this->attributes['updated_at']);
    }

}