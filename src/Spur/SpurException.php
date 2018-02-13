<?php

namespace Spur;

class SpurException extends \Exception
{
    public $message;
    public $http_status_code;
    public $spur_api_error_code;
}
