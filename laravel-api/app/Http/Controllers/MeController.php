<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MeController extends Controller
{
    public function __invoke()
    {
        try {
            return UserResource::make(Auth::user());
        } catch (Exception $e) {
            $this->logError($e, 'Failed to get user data');
            return $this->somethingWentWrong();
        }
    }
}
