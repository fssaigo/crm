<?php
namespace App\Util;

/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/10/12
 * Time: 15:31
 */
class Helper
{
    public static function removeNull($data) {
        foreach ($data as $key => $val) {
            if ($val === NULL) {
                unset($data[$key]);
            }
        }
        return $data;
    }

    /**
     * 传递一个二维数组进来,然后返回这个数组的ID，用于解决单表查询关联其他表的信息
     * @param $data
     * @param string $key0
     * @param string $key1
     * @param string $key2
     * @param string $key3
     * @param string $key4
     * @return array
     */
    public static function returnArrayVal($data, $key0 = '', $key1 = '', $key2 = '', $key3 = '', $key4 = '') {
        $result = [0];
        if (is_array($data)) {
            foreach ($data as $record) {
                if ($key0 && intval($record[$key0])) {
                    $result[] = intval($record[$key0]);
                }
                if ($key1 && intval($record[$key1])) {
                    $result[] = intval($record[$key1]);
                }
                if ($key2 && intval($record[$key2])) {
                    $result[] = intval($record[$key2]);
                }
                if ($key3 && intval($record[$key3])) {
                    $result[] = intval($record[$key3]);
                }
                if ($key4 && intval($record[$key4])) {
                    $result[] = intval($record[$key4]);
                }
            }
        }
        return $result;
    }

    /**
     * 过滤SQL注入攻击字符串
     * @param string $ids 检测是否是一个 1,32,23,3 这样的字符串
     * @return string
     */
    public static function isIds($ids) {
        if (preg_match('/^[1-9]\d{0,7}(,[1-9]\d{0,7})*$/', $ids)){
            return True;
        }
        return False;
    }

    public static function rLevel($primary, $arr, &$arr2 = Array(), $perId = 0, $lv=0) {
        if ((bool)$arr) {
            foreach ($arr as $value) {
                if ($value['parent_id'] == $perId) {
                    $value['lv'] = $lv;
                    $arr2[$value[$primary]] = $value;
                    $lv++;
                    self::rLevel($primary, $arr, $arr2, $value[$primary], $lv--);
                }
            }
        }
    }

    public static function refactor($primary, $input, &$output = Array(), $perId = 0) {
        if ((bool)$input) {
            $check = False;
            foreach ($input as $key => $val) {
                if ($val['parent_id'] == $perId) {
                    $check = True;
                    $output[$val[$primary]] = $val;
                    self::refactor($primary, $input, $output[$val[$primary]]['submenu'], $val[$primary]);
                }
            }
            if (!$check) {
                $output = null; //this node have not child
            }
        }
    }

    public static function refactorNoKey($primary, $input, &$output = Array(), $perId = 0) {
        if ((bool)$input) {
            $check = False;
            foreach ($input as $key => $val) {
                if ($val['parent_id'] == $perId) {
                    $check = True;
                    $output[] = $val;
                    $key = key($output);
                    next($output);
                    self::refactorNoKey($primary, $input, $output[$key]['sub'], $val[$primary]);
                }
            }
            if (!$check) {
                $output = []; //this node have not child
            }
        }
    }
}