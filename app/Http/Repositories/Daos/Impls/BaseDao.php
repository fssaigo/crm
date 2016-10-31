<?php

namespace App\Http\Repositories\Daos\Impls;

use App\Http\Repositories\Daos\IBaseDao;

/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/9/12
 * Time: 16:59
 */
class BaseDao implements IBaseDao
{

    protected $model;

    protected $query;

    public function __construct($model)
    {
        $this->model = $model;
        $this->query = $this->model->newQuery();
    }

    public function findOne($id)
    {
        return $this->model->find($id);
    }

    public function findByIds($ids)
    {
        return $this->model->whereIn('id', $ids)->get()->toArray();
    }

    public function findByKeyIsVal($key, $val) {
        return $this->model->where($key, '=', $val)->get()->toArray();
    }

    public function findByKeyInVal($key, $val) {
        $data = [];
        $result = $this->model->whereIn($key, $val)->get()->toArray();
        if ($result) {
            foreach ($result as $record) {
                $data[$record[$key]] = $record;
            }
        }
        return $data;
    }

    public function findMapByIds(Array $ids, $key = '')
    {
        $rtnTemp = [];
        if ($key) {
            $this->model->select('id',$key);
        }
        $data = $this->model->whereIn('id', $ids)->get();
        if ($data) {
            $arrTemp = $data->toArray();
            if ($key) {
                $rtnTemp[0] = '';
                foreach ($arrTemp as $record) {
                    $rtnTemp[$record['id']] = $record[$key];
                }
            } else {
                foreach ($arrTemp as $record) {
                    $rtnTemp[$record['id']] = $record;
                }
            }
        }
        return $rtnTemp;
    }

    public function save($data)
    {
        return $this->model->create($data);
    }

    /**
     * @param $id
     * @param $data
     * @return miboolxed
     */
    public function update($id, $data)
    {
        return $this->model->where('id', $id)->update($data);
    }
    
    /**
     * @param $id
     * @param $data
     * @return 实例
     */
    public function fill($id, $data) {
        $model = $this->model->findOrFail($id)->fill($data);
        $model->save();
        return $model;
    }

    public function page($offset = 0, $size = 10, $order = ['id'=>'desc']) {

        $result = ['totalCount'=>0, 'results'=>[]];

        $offset = intval($offset);

        $size = intval($size) ? intval($size) : $this->model->getPerPage();

        $result['totalCount'] = $this->query->count();

        if ($result['totalCount'] > 0) {
            if ((bool)$order) {
                foreach ($order as $key => $sort) {
                    $this->query->orderBy($key, $sort);
                }
            }
            $result['results'] = $this->query->skip($offset)->take($size)->get()->toArray();
        }

        return $result;

    }

    public function toSql($filter = null) {
        if ($filter) {
            return $filter->toSql();
        } else {
            return $this->query->toSql();
        }
    }

}