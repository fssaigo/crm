<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/10/8
 * Time: 17:25
 */

namespace App\Http\Repositories\Daos\Impls;


use App\Http\Repositories\Daos\IPondDao;
use App\Http\Repositories\Eloquent\Pond;

class PondDao extends BaseDao implements IPondDao
{
    public function __construct(Pond $model)
    {
        parent::__construct($model);
    }

    public function findPond($search, $offset, $size)
    {
        if (isset($search['groupId']) && $search['groupId'] > 0) {
            $this->query->where('group_id','=', $search['groupId']);
        }
        if (isset($search['channelId']) && $search['channelId'] > 0) {
            $this->query->where('channel_id','=', $search['channelId']);
        }
        if (isset($search['isDistribution'])) {
            if ($search['isDistribution'] > 0) {
                $this->query->where('customer_id','>', 0);
            } else {
                $this->query->where('customer_id','=', 0);
            }
        }
        if (isset($search['bgnTime']) && $search['bgnTime'] > 0) {
            $this->query->where('created_at','>', substr($search['bgnTime'], 0, -3));
        }
        if (isset($search['endTime']) && $search['endTime'] > 0) {
            $this->query->where('created_at','<', substr($search['endTime'], 0, -3));
        }

        $order = [];
        $order['id'] = 'desc';
        $order['customer_id'] = 'asc';
        $order['created_at'] = 'desc';

        return $this->page($offset, $size);
    }
}