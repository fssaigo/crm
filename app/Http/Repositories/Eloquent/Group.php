<?php

namespace App\Http\Repositories\Eloquent;

class Group extends Orm
{

    /**
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'merchant_id' => 'integer',
    ];

    public function getId() {
        return $this->attributes['id'];
    }
    public function setId($id) {
        $this->attributes['id'] = intval($id);
    }
    public function getUserId() {
        return $this->attributes['user_id'];
    }
    public function setUserId($userId) {
        $this->attributes['user_id'] = intval($userId);
    }
    public function getMerchantId() {
        return $this->attributes['merchant_id'];
    }
    public function setMerchantId($merchantId) {
        $this->attributes['merchant_id'] = intval($merchantId);
    }
    public function getName() {
        return $this->attributes['name'];
    }
    public function setName($name) {
        $this->attributes['name'] = $name;
    }
    public function getLogo() {
        return $this->attributes['logo'];
    }
    public function setLogo($logo) {
        $this->attributes['logo'] = $logo;
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
