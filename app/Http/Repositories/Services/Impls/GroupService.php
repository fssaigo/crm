<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/9/18
 * Time: 15:15
 */

namespace App\Http\Repositories\Services\Impls;

use App\Http\Constants\CommonExceptionConstants;
use App\Http\Repositories\Daos\IGroupDao;
use App\Http\Repositories\Daos\IUserDao;
use App\Http\Repositories\Eloquent\Group;
use App\Exceptions\ServiceException;
use App\Http\Repositories\Services\ICustomer;
use App\Http\Repositories\Services\IGroup;
use App\Http\Repositories\Services\IUser;
use App\Http\Requests\SysUserContext;
use App\Util\Helper;

class GroupService implements IGroup
{

    protected $userDao;
    protected $groupDao;
    protected $merchantService;
    protected $customerService;
    protected $userService;

    public function __construct(IGroupDao $groupDao, MerchantService $merchantService, ICustomer $customerService, IUserDao $userDao, IUser $userService)
    {
        $this->userDao = $userDao;
        $this->groupDao = $groupDao;
        $this->merchantService = $merchantService;
        $this->customerService = $customerService;
        $this->userService = $userService;
    }

    public function findByList($search, $offset, $size)
    {
        $data = $this->groupDao->findGroup($search, $offset, $size);
        $userIds = Helper::returnArrayVal($data['results'], 'user_id');
        $userList = $this->userDao->findMapByIds($userIds, 'name');
        foreach ($data['results'] as $key => $record) {
            $data['results'][$key]['user_name'] = $userList[$record['user_id']];
        }
        return $data;
    }

    public function findById($id)
    {
        $id = intval($id);
        if (!$id) {
            throw new ServiceException(CommonExceptionConstants::getKey('not_available_data'));
        }
        $data = $this->groupDao->findOne($id);
        if ($data) {
            $data = $data->toArray();
            return $data;
        } else {
            throw new ServiceException(CommonExceptionConstants::getKey('no_find_data'));
        }
    }

    public function saveGroup(SysUserContext $sysUserContext, $input)
    {

        if (!$sysUserContext->getIsLeader()) {
            throw new ServiceException(CommonExceptionConstants::getKey('no_data_permission'));
        }

        if ($this->groupDao->findByName($input['name'])) {
            throw new ServiceException(CommonExceptionConstants::getKey('repeat_name_error'));
        }

        $group = new Group();
        $group->setUserId($input['userId']);
        $group->setMerchantId($sysUserContext->getMerchantId());
        $group->setName($input['name']);


        if ($group->save()) {
            if (isset($input['userId']) && $input['userId']) {
                $this->userService->setRole($sysUserContext, $input['userId'], 2);
            }
        } else {
            throw new ServiceException(CommonExceptionConstants::getKey('data_save_failed'));
        }

    }

    public function editGroup(SysUserContext $sysUserContext, $input, $id)
    {

        if (!(bool)$input) {
            throw new ServiceException(CommonExceptionConstants::getKey('not_available_data'));
        }
        if (!$id) {
            throw new ServiceException(CommonExceptionConstants::getKey('not_available_data'));
        }

        $group = $this->groupDao->findOne($id);

        if (!$group) {
            throw new ServiceException(CommonExceptionConstants::getKey('no_find_data'));
        }

        if (!$sysUserContext->getIsLeader()) {
            throw new ServiceException(CommonExceptionConstants::getKey('no_data_permission'));
        }

        if (isset($input['userId']) && $input['userId']) {
            $group->setUserId($input['userId']);
        }
        if (isset($input['name']) && $input['name']) {
            $group->setName($input['name']);
        }
        if (isset($input['deleted']) && $input['deleted']) {
            $group->setIsDeleted($input['deleted']);
        }

        if (!$group->save()) {
            if (isset($input['userId']) && $input['userId']) {
                $this->userService->setRole($sysUserContext, $input['userId'], 2);
            }
            throw new ServiceException(CommonExceptionConstants::getKey('no_data_updated'));
        }

    }

    public function findGroupLeaderId($groupId)
    {
        $result = $this->groupDao->findOne($groupId);
        return intval($result->user_id);
    }


}