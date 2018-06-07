<?php

namespace Spur;

class SpurApiException extends \Exception
{
    public function __construct($message, $code)
    {
        parent::__construct($message);

        $this->code = $code;
    }
}
