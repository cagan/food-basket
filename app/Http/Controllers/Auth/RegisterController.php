<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Notifications\SignUpActivate;
use App\User;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create(
            [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'activation_token' => Str::random(60),
            ]
        );

        $this->storeAvatar($user);
        $user->notify(new SignUpActivate($user));

        return response()->json(
            [
                'message' => 'Verification e-mail has been sent. Please check your email',
                'status' => 'success',
            ],
            Response::HTTP_CREATED
        );
    }

    public function activateUser(string $token)
    {

        $user = User::where('activation_token', $token)->first();

        if (!$user) {
            response()->json(
                [
                    'message' => 'This activation token is invalid',
                    'status' => 'error',
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        $user->update(
            [
                'active' => true,
                'activation_token' => '',
            ]
        );

        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}
