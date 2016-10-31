<?php

namespace App\Http\Repositories\Eloquent;

class Customer extends Orm
{
    /**
     * @var array
     */
    protected $casts = [
        'is_managed' => 'integer',
    ];

    protected $guarded = array('id');

}
