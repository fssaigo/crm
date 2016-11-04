<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/9/28
 * Time: 14:36
 */

namespace App\Http\Repositories\Services\Impls;


use App\Exceptions\ServiceException;
use App\Http\Constants\CommonExceptionConstants;
use App\Http\Constants\ServiceExceptionConstants;
use App\Http\Repositories\Daos\IGroupDao;
use App\Http\Repositories\Daos\IMerchantDao;
use App\Http\Repositories\Daos\IUserDao;
use App\Http\Repositories\Services\IUser;
use App\Http\Requests\SysUserContext;
use App\Http\Repositories\Eloquent\User;

class UserService implements IUser
{

    protected $userDao;
    protected $merchantDao;
    protected $groupDao;

    public function __construct(IUserDao $userDao, IGroupDao $groupDao, IMerchantDao $merchantDao)
    {
        $this->userDao = $userDao;
        $this->groupDao = $groupDao;
        $this->merchantDao = $merchantDao;
    }

    public function findByUserId($id)
    {
        $id = intval($id);
        if (!$id) {
            throw new ServiceException(CommonExceptionConstants::getKey('not_available_data'));
        }
        $data = $this->userDao->findOne($id);
        if ($data) {
            return $data;
        } else {
            throw new ServiceException(CommonExceptionConstants::getKey('no_find_data'));
        }
    }

    public function findUserByName($merchantId, $name) {
        return $this->userDao->findUserByName($merchantId, $name);
    }

    public function findUserList($search, $offset, $size)
    {
        $data = $this->userDao->findUser($search, $offset, $size);
        return $data;
    }

    public function saveUser(SysUserContext $sysUserContext, $input)
    {

        if (!$sysUserContext->getIsLeader() && !$sysUserContext->getIsCharge()) {
            throw new ServiceException(CommonExceptionConstants::getKey('no_jurisdiction'));
        }

        if ($this->userDao->findByEmail($input['email'])) {
            throw new ServiceException(CommonExceptionConstants::getKey('repeat_email_error'));
        }

        $password = bcrypt($input['password']);

        $user = new User();
        $user->setMerchantId($sysUserContext->getMerchantId());
        $user->setUserRoleId($input['userRoleId']);
        $user->setGroupId(intval($input['groupId']));
        $user->setName($input['name']);
        $user->setEmail($input['email']);
        $user->setPassword($password);
        $user->setMobile($input['mobile']);

        if ($user->save()) {
            $this->setRoleInfo($user->id, $input['userRoleId'], $input['groupId'], $sysUserContext->getMerchantId());
            return $user->id;
        } else {
            throw new ServiceException(CommonExceptionConstants::getKey('data_save_failed'));
        }

    }



    public function editUser(SysUserContext $sysUserContext, $input, $id)
    {

        if (!(bool)$input) {
            throw new ServiceException(CommonExceptionConstants::getKey('not_available_data'));
        }

        if (!$id) {
            throw new ServiceException(CommonExceptionConstants::getKey('not_available_data'));
        }

        if (!$sysUserContext->getIsLeader() && !$sysUserContext->getIsCharge()) {
            throw new ServiceException(CommonExceptionConstants::getKey('no_jurisdiction'));
        }

        $user = $this->userDao->findOne($id);

        if (!$user) {
            throw new ServiceException(CommonExceptionConstants::getKey('no_find_data'));
        }

        if (isset($input['groupId']) && $input['groupId']) {
            $user->setGroupId($input['groupId']);
        }
        if (isset($input['userRoleId']) && $input['userRoleId']) {
            $user->setUserRoleId($input['userRoleId']);
        }
        if (isset($input['name']) && $input['name']) {
            $user->setName($input['name']);
        }
        if (isset($input['mobile']) && $input['mobile']) {
            $user->setMobile($input['mobile']);
        }
        if (isset($input['password']) && $input['password']) {
            //$user->setPassword(bcrypt($input['password']));
        }
        if (isset($input['deleted']) && $input['deleted']) {
            //$user->setIsDeleted($input['deleted']);
        }

        $user->save();

        $this->setRoleInfo($id, $input['userRoleId'], $input['groupId'], $user->merchant_id);

    }

    public function setRoleInfo($userId, $roleId, $groupId, $merchantId) {
        switch ($roleId) {
            case 2:
                $update = [];
                $update['user_id'] = $userId;
                $this->groupDao->update($groupId, $update);
                break;
            case 4:
                $update = [];
                $update['user_id'] = $userId;
                $this->merchantDao->update($merchantId, $update);
                break;
        }
    }

    public function setRole(SysUserContext $sysUserContext, $userId, $userRoleId) {
        $update = [];
        $update['userRoleId'] = $userRoleId;
        $this->editUser($sysUserContext, $update, $userId);
    }

    public function Login($input) {

        $result = $this->userDao->findByEmail($input['email']);

        if (!$result) {
            throw new ServiceException(ServiceExceptionConstants::getKey('login_fail'));
        }

        if (!password_verify($input['password'], $result['password'])) {
            throw new ServiceException(ServiceExceptionConstants::getKey('login_fail'));
        }

        if (!$result['merchant_id']) {
            throw new ServiceException(ServiceExceptionConstants::getKey('user_no_merchant'));
        }

        if (!$result['user_role_id']) {
            throw new ServiceException(ServiceExceptionConstants::getKey('user_no_role'));
        }

        $data = [];
        $data['id'] = $result['id'];
        $data['merchant_id'] = $result['merchant_id'];
        $data['group_id'] = $result['group_id'];
        $data['user_role_id'] = $result['user_role_id'];
        $data['email'] = $result['email'];
        $data['name'] = $result['name'];
        $data['is_leader'] = $data['user_role_id'] == 4 ? 1 : 0;
        $data['is_distribution'] = $data['user_role_id'] == 3 ? 1 : 0;
        $data['is_charge'] = $data['user_role_id'] == 2 ? 1 : 0;
        $data['is_sale'] = $data['user_role_id'] == 1 ? 1 : 0;

        session(['User' => $data]);

        return $data;

    }

    public function sendEmail($data)
    {
        // TODO: Implement sendEmail() method.
    }

    public function sendMsg($data)
    {
        // TODO: Implement sendMsg() method.
    }

}