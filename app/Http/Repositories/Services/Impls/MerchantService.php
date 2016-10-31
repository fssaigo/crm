<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/9/22
 * Time: 9:53
 */

namespace App\Http\Repositories\Services\Impls;


use App\Exceptions\ServiceException;
use App\Http\Repositories\Daos\IMerchantDao;
use App\Http\Repositories\Services\IMerchant;
use App\Http\Repositories\Services\IUser;
use App\Http\Requests\SysUserContext;

class MerchantService implements IMerchant
{

    protected $merchantDao;
    protected $userService;

    public function __construct(IMerchantDao $merchantDao, IUser $userService)
    {
        $this->merchantDao = $merchantDao;
        $this->userService = $userService;
    }

    public function findMerchantById($id) {
        $id = intval($id);
        if (!$id) {
            throw new ServiceException(CommonExceptionConstants::getKey('not_available_data'));
        }
        $data = $this->merchantDao->findOne($id);
        if ($data) {
            return $data;
        } else {
            throw new ServiceException(CommonExceptionConstants::getKey('no_find_data'));
        }
    }

    public function findMerchantList($search, $offset, $size) {
        return $this->merchantDao->findMerchant($search, $offset, $size);
    }

    public function getMerchantUserId($merchantId)
    {
        $data = $this->merchantDao->findOne($merchantId);
        if ($data) {
            $data = $data->toArray();
            return $data['user_id'];
        } else {
            return 0;
        }
    }

    public function editMerchant(SysUserContext $sysUserContext, $input, $id)
    {
        if (!(bool)$input) {
            throw new ServiceException(CommonExceptionConstants::getKey('not_available_data'));
        }
        if ($id) {
            $merchant = $this->merchantDao->findOne($id);
            if ($merchant) {
                if (!$sysUserContext->getIsLeader()) {
                    throw new ServiceException(CommonExceptionConstants::getKey('no_data_permission'));
                }
                if (isset($input['userId']) && $input['userId']) {
                    $merchant->setUserId($input['userId']);
                }
                if (isset($input['name']) && $input['name']) {
                    $merchant->setName($input['name']);
                }
                if (isset($input['contacter']) && $input['contacter']) {
                    $merchant->setContacter($input['contacter']);
                }
                if (isset($input['mobile']) && $input['mobile']) {
                    $merchant->setMobile($input['mobile']);
                }
                if (isset($input['deleted']) && $input['deleted']) {
                    $merchant->setIsDeleted($input['deleted']);
                }
                if (!$merchant->save()) {
                    if (isset($input['userId']) && $input['userId']) {
                        $this->userService->setRole($sysUserContext, $input['userId'], 4);
                    }
                    if (isset($input['assigner']) && $input['assigner']) {
                        $this->userService->setRole($sysUserContext, $input['userId'], 3);
                    }
                    throw new ServiceException(CommonExceptionConstants::getKey('no_data_updated'));
                }
            } else {
                throw new ServiceException(CommonExceptionConstants::getKey('no_find_data'));
            }
        } else {
            throw new ServiceException(CommonExceptionConstants::getKey('not_available_data'));
        }
    }

}