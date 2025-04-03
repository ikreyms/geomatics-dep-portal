<?php

namespace App\Contracts;

interface ControllerAction
{
    /**
     * Perform some action.
     *
     * @param array $data
    //  * @return 
     */
    public static function run(array $data);
}
