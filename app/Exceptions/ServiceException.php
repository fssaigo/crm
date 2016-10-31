<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/9/5
 * Time: 15:17
 */

namespace App\Exceptions;

use RuntimeException;

class ServiceException extends RuntimeException
{

    protected $code;

    protected $message;

    public function __construct($data) {
        $this->setCode($data['code']);
        $this->setMessage($data['message']);
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

}