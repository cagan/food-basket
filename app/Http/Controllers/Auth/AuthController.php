<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Notifications\SignUpActivate;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravolt\Avatar\Avatar;
use Storage;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
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

    protected function storeAvatar(User $user): void
    {
        $avatar = (new Avatar())->create($user->name)->getImageObject()->encode('png');
        Storage::put('avatars/' . $user->id . '/avatar.png', (string)$avatar);
    }

    public function signupActivate(string $token)
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

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json(
            [
                'message' => 'Successfully logged out',
                'status' => 'success',
            ],
            Response::HTTP_UNAUTHORIZED
        );
    }

    public function user(Request $request)
    {
        return response()->json($request->user(), Response::HTTP_OK);
    }
}
