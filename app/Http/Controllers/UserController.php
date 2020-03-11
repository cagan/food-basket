<?php

namespace App\Http\Controllers;

use App\ResponseType;
use App\User;

class UserController extends Controller
{

    public function makeUserAsAdmin($id)
    {
        $user = User::find($id)->first();

        if (!$user) {
            return response()->json(ResponseType::USER_NOT_FONUD);
        }

        if (!$user->setUserAsAdmin()) {
            return response()->json(ResponseType::USER_NOT_ADMIN);
        }

        return response()->json(ResponseType::USER_SET_ADMIN_SUCCESS);
    }
}
