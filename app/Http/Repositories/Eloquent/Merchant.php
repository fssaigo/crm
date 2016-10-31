<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/9/20
 * Time: 18:07
 */

namespace App\Http\Repositories\Eloquent;

class Merchant extends Orm
{

    public function getId()
    {
        return $this->attributes['id'];
    }
    public function setId($id)
    {
        $this->attributes['id'] = $id;
    }
    public function getUserId()
    {
        return $this->attributes['user_id'];
    }
    public function setUserId($id)
    {
        $this->attributes['user_id'] = $id;
    }
    public function getName()
    {
        return $this->attributes['name'];
    }
    public function setName($name)
    {
        $this->attributes['name'] = $name;
    }
    public function getContacter()
    {
        return $this->attributes['contacter'];
    }
    public function setContacter($contacter)
    {
        $this->attributes['contacter'] = $contacter;
    }
    public function getMobile()
    {
        return $this->attributes['mobile'];
    }
    public function setMobile($mobile)
    {
        $this->attributes['mobile'] = $mobile;
    }
    public function getAssigner()
    {
        return $this->attributes['assigner'];
    }
    public function setAssigner($assigner)
    {
        $this->attributes['assigner'] = $assigner;
    }
    public function getIsDeleted()
    {
        return $this->attributes['is_deleted'];
    }
    public function setIsDeleted($isDeleted)
    {
        $this->attributes['is_deleted'] = $isDeleted;
    }
}