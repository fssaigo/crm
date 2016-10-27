<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/10/14
 * Time: 15:49
 */

namespace App\Http\Repositories\Daos\Impls;

use App\Http\Repositories\Daos\IChinaDao;
use App\Http\Repositories\Eloquent\China;

class ChinaDao extends BaseDao implements IChinaDao
{

    public function __construct(China $model)
    {
        parent::__construct($model);
    }

    public function province(Array $code)
    {
        $return = [0=>''];
        $data = $this->model->select('province_code','province_name')->whereIn('province_code', $code)->get();
        if ($data) {
            $result = $data->toArray();
            if ($result) {
                $arrTmp = [];
                foreach ($result as $record) {
                    $arrTmp[$record['province_code']] = $record['province_name'];
                }
                foreach ($code as $key => $val) {
                    $return[$val] =  isset($arrTmp[$val]) ? $arrTmp[$val] : '';
                }
            }
            return $return;
        } else {
            return false;
        }
    }

    public function city(Array $code)
    {
        $return = [0=>''];
        $data = $this->model->select('city_code','city_name')->whereIn('city_code', $code)->get();
        if ($data) {
            $result = $data->toArray();
            if ($result) {
                $arrTmp = [];
                foreach ($result as $record) {
                    $arrTmp[$record['city_code']] = $record['city_name'];
                }
                foreach ($code as $key => $val) {
                    $return[$val] =  isset($arrTmp[$val]) ? $arrTmp[$val] : '';
                }
            }
            return $return;
        } else {
            return false;
        }
    }

    public function district(Array $code)
    {
        $return = [0=>''];
        $data = $this->model->select('district_code','district_name')->whereIn('district_code', $code)->get();
        if ($data) {
            $result = $data->toArray();
            if ($result) {
                $arrTmp = [];
                foreach ($result as $record) {
                    $arrTmp[$record['district_code']] = $record['district_name'];
                }
                foreach ($code as $key => $val) {
                    $return[$val] =  isset($arrTmp[$val]) ? $arrTmp[$val] : '';
                }
            }
            return $return;
        } else {
            return false;
        }
    }


}