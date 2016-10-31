<?php

namespace App\Http\Repositories\Eloquent;

class Pond extends Orm
{
    /**
     * @var array
     */
    protected $casts = [
        'merchant_id' => 'integer',
    ];

    //
    protected $fillable = ['customer_id','name','email','weixin','phone','mobile','qq','project'];

    public function getId()
    {
        return $this->attributes['id'];
    }
    public function setId($id)
    {
        $this->attributes['id'] = $id;
    }
    public function getCustomerId()
    {
        return $this->attributes['customer_id'];
    }
    public function setCustomerId($id)
    {
        $this->attributes['customer_id'] = $id;
    }
    public function getName() {
        return $this->attributes['name'];
    }
    public function setName($name) {
        $this->attributes['name'] = $name;
    }
    public function getMobile()
    {
        return $this->attributes['mobile'];
    }
    public function setMobile($mobile)
    {
        $this->attributes['mobile'] = $mobile;
    }
    public function getQq()
    {
        return $this->attributes['qq'];
    }
    public function setQq($qq)
    {
        $this->attributes['qq'] = $qq;
    }
    public function getEmail()
    {
        return $this->attributes['email'];
    }
    public function setEmail($email)
    {
        $this->attributes['email'] = $email;
    }
}
