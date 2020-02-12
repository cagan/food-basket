<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use App\Http\Resources\TokenResource;
use App\Http\Resources\UserResource;
use App\Notifications\SignUpActivate;
use App\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravolt\Avatar\Avatar;
use Storage;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function signup(SignupRequest $request)
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

    public function login(LoginRequest $request)
    {
        $credentials = request(['email', 'password']);
        $credentials['active'] = 1;
        $credentials['deleted_at'] = null;

        if (!Auth::attempt($credentials)) {
            return response()->json(
                [
                    'message' => 'Unauthorized',
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }

        $user = $request->user();

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        if ($request->input('remember_me')) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }

        $token->save();

        return new TokenResource($tokenResult);
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
