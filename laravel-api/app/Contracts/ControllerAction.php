<?php

namespace App\Contracts;

interface ControllerAction
{
    /**
     * Execute an action with the provided data.
     *
     * This method handles the logic for creating or updating a model using the
     * given data.
     *
     * @param array $data The input data needed for the action (e.g., model attributes).
     * @return mixed The result of the action (e.g., created/updated model, status).
     */
    public static function run(array $data);
}
