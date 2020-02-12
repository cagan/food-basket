<?php

namespace App\Http\Controllers;

use App\User;

class UserController extends Controller
{

    public function makeUserAsAdmin($id)
    {
        $token = header('Authorization');
        $user = User::find($id)->first();

        if (!$user) {
            return response()->json(
                [
                    'message' => 'There is no user with this id',
                    'status' => 'error',
                ]
            );
        }

        if (!$user->setUserAsAdmin()) {
            return response()->json(
                [
                    'message' => 'You are not admin, no permission.',
                    'status' => 'error',
                ]
            );
        }

        return response()->json(
            [
                'message' => "User: $id has been set as admin.",
                'status' => 'success',
            ]
        );
    }
}
