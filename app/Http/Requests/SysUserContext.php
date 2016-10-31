<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/9/20
 * Time: 13:28
 */

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SysUserContext
{

    private $id;

    private $roleId;

    private $merchantId;

    private $groupId;

    private $email;

    private $userName;

    private $isLeader;

    private $isDistribution;

    private $isCharge;

    private $isSale;

    private $remoteIp;

    private $agent;

    public function __construct()
    {
        /**
            $this->setId(Auth::User()['id']);
            $this->setMerchantId(Auth::User()['merchant_id']);
            $this->setGroupId(Auth::User()['group_id']);
            $this->setEmail(Auth::User()['email']);
            $this->setUserName(Auth::User()['name']);
        */

        //$this->setRemoteIp(Request::ip());
        //$this->setAgent(Auth::User()['id']);

        $data = session('User');
        $this->setId($data['id']);
        $this->setRoleId($data['user_role_id']);
        $this->setMerchantId($data['merchant_id']);
        $this->setGroupId($data['group_id']);
        $this->setEmail($data['email']);
        $this->setUserName($data['name']);
        $this->setIsCharge($data['is_charge']);
        $this->setIsLeader($data['is_leader']);
        $this->setIsDistribution($data['is_distribution']);
        $this->setIsSale($data['is_sale']);

    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return  $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getRoleId()
    {
        return  $this->roleId;
    }

    /**
     * @param mixed $roleId
     */
    public function setRoleId($roleId)
    {
        $this->roleId = $roleId;
    }

    /**
     * @return mixed
     */
    public function getMerchantId()
    {
        return $this->merchantId;
    }

    /**
     * @param mixed $merchantId
     */
    public function setMerchantId($merchantId)
    {
        $this->merchantId = $merchantId;
    }

    /**
     * @return mixed
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * @param mixed $groupId
     */
    public function setGroupId($groupId)
    {
        $this->groupId = $groupId;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }



    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @param mixed $userName
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    public function getIsLeader() {
        return $this->isLeader;
    }

    public function setIsLeader($value) {
        $this->isLeader = $value;
    }

    public function getIsDistribution() {
        return $this->isDistribution;
    }

    public function setIsDistribution($value) {
        $this->isDistribution = $value;
    }

    public function getIsCharge() {
        return $this->isCharge;
    }

    public function setIsCharge($value) {
        $this->isCharge = $value;
    }

    public function getIsSale() {
        return $this->isSale;
    }

    public function setIsSale($value) {
        $this->isSale = $value;
    }

    /**
     * @return mixed
     */
    public function getRemoteIp()
    {
        return $this->remoteIp;
    }

    /**
     * @param mixed $remoteIp
     */
    public function setRemoteIp($remoteIp)
    {
        $this->remoteIp = $remoteIp;
    }

    /**
     * @return mixed
     */
    public function getAgent()
    {
        return $this->agent;
    }

    /**
     * @param mixed $agent
     */
    public function setAgent($agent)
    {
        $this->agent = $agent;
    }

}