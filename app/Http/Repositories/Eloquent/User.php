<?php

namespace App\Http\Repositories\Eloquent;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Orm
{

    protected $hidden = ['password','remember_token','is_deleted'];

    public function getId()
    {
        return $this->attributes['id'];
    }
    public function setId($id)
    {
        $this->attributes['id'] = $id;
    }
    public function getMerchantId()
    {
        return $this->attributes['merchant_id'];
    }
    public function setMerchantId($merchantId)
    {
        $this->attributes['merchant_id'] = $merchantId;
    }
    public function getGroupId()
    {
        return $this->attributes['group_id'];
    }
    public function setGroupId($groupId)
    {
        $this->attributes['group_id'] = $groupId;
    }
    public function getUserRoleId() {
        return $this->attributes['user_role_id'];
    }
    public function setUserRoleId($userRoleId) {
        $this->attributes['user_role_id'] = $userRoleId;
    }
    public function getName()
    {
        return $this->attributes['name'];
    }
    public function setName($name)
    {
        $this->attributes['name'] = $name;
    }
    public function getEmail()
    {
        return $this->attributes['email'];
    }
    public function setEmail($email)
    {
        $this->attributes['email'] = $email;
    }
    public function getPassword()
    {
        return $this->attributes['password'];
    }
    public function setPassword($password)
    {
        $this->attributes['password'] = $password;
    }
    public function getMobile()
    {
        return $this->attributes['mobile'];
    }
    public function setMobile($mobile)
    {
        $this->attributes['mobile'] = $mobile;
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