<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/10/14
 * Time: 15:42
 */

namespace App\Http\Repositories\Daos\Impls;


use App\Http\Repositories\Daos\IChannelDao;
use App\Http\Repositories\Eloquent\Channel;

class ChannelDao extends BaseDao implements IChannelDao
{

    public function __construct(Channel $model)
    {
        parent::__construct($model);
    }

}