<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/9/27
 * Time: 11:16
 */

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class MerchantFacade extends Facade
{

    protected static function getFacadeAccessor() {
        return 'MerchantService';
        #return 'App\Http\Repositories\Services\MerchantInterface';
    }

}