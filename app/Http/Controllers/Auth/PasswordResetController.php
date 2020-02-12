<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordResetCreateRequest;
use App\Http\Requests\PasswordResetRequest;
use App\Notifications\PasswordResetSuccess;
use App\PasswordReset;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{

    /**
     * Create token password reset
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(PasswordResetCreateRequest $request)
    {
        $user = User::where('email', $request->input('email'))->first();

        if (!$user) {
            return response()->json([
                'message' => 'We cant find a user with that e-mail address.',
                'status' => 'error',
            ]);
        }

        $passwordReset = PasswordReset::updateOrCreate(
            [
                'email' => $user->email,
            ],
            [
                'email' => $user->email, 'token' => Str::random(60),
            ]
        );

        if (!$passwordReset) {
            return response()->json([
                'message' => 'Can not create or update password',
                'status' => 'error',
            ]);
        }

        $user->notify(
            new PasswordResetRequest($passwordReset->token)
        );

        return response()->json([
            'message' => 'We have e-mailed your password reset link!',
            'status' => 'success',
        ]);
    }

    /**
     * Find token password reset
     * @param $token
     * @return JsonResponse
     */
    public function find(string $token)
    {
        $passwordReset = PasswordReset::where('token', $token)->first();

        if (!$passwordReset) {
            return response()->json([
                'message' => 'This password reset token is invalid',
            ], 404);
        }

        if (Carbon::parse($passwordReset->update_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();

            return response()->json([
                'message' => 'This password reset token is invalid.',
            ], 404);
        }

        return response()->json($passwordReset);
    }

    public function reset(PasswordResetRequest $request)
    {
        $passwordReset = PasswordReset::where([
            ['token', $request->input('token')],
            ['email', $request->input('email')],
        ])->first();

        if (!$passwordReset) {
            return response()->json([
                'message' => 'This password reset token is invalid',
                'status' => 'error',
            ], 404);
        }

        $user = User::where('email', $passwordReset->email)->first();

        if (!$user) {
            return response()->json([
                'message' => 'We can not find a user with that e-mail address',
                'status' => 'error',
            ], 404);
        }

        $user->create([
            'password' => bcrypt($request->input('password')),
        ]);

        $passwordReset->delete();

        $user->notify(new PasswordResetSuccess($passwordReset));

        return response()->json($user);
    }
}

