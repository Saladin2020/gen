<?php

namespace Saladin;

class RespondMsg
{
    public static function build($msg)
    {
        return array(
            "status" => 200,
            "massege" => $msg
        );
    }
}
