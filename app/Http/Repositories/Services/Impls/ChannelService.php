<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/10/8
 * Time: 13:13
 */

namespace App\Http\Repositories\Services\Impls;


use App\Http\Repositories\Eloquent\Channel;
use App\Http\Repositories\Services\IChannel;
use App\Http\Requests\SysUserContext;

class ChannelService implements IChannel
{
    public function getMyChannel(SysUserContext $sysUserContext) {
        $data = Channel::where('is_deleted', '=', '0')->orderBy('sort')->get();
        if ((bool)$data) {
            $data = $data->toArray();
        } else {
            $data = [];
        }
        return $data;
    }
}