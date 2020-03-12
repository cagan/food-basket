<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Notifications\SignUpActivate;
use App\Repositories\UserRepositoryInterface;
use App\Services\Avatar\AvatarServiceInterface;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    public function register(
        RegisterRequest $request,
        AvatarServiceInterface $avatarService,
        UserRepositoryInterface $userRepository
    ) {
        $user = $userRepository->create(
            [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'activation_token' => Str::random(60),
            ]
        );

        $avatarService->store($user);

        $user->notify(new SignUpActivate($user));

        return response()->json(
            [
                'message' => 'Verification e-mail has been sent. Please check your email',
                'status' => 'success',
            ],
            Response::HTTP_CREATED
        );
    }

    public function activateUser(string $token, UserRepositoryInterface $userRepository)
    {
        $user = $userRepository->findBy('activation_token', $token);

        if (!$user) {
            response()->json(
                [
                    'message' => 'This activation token is invalid',
                    'status' => 'error',
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        $userRepository->update($user->id, ['active' => true, 'activation_token' => '']);

        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}
