<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Http\Resources\UserResource;
use App\Services\User\UserService;

class UserController extends Controller
{
    public function __construct(private readonly UserService $userService) {}

    /**
     * @param StoreRequest $request
     * @return UserResource
     */
    public function store(StoreRequest $request): UserResource
    {
        $user = $this->userService->create(
            $request->getName(),
            $request->getEmail(),
            $request->getPasswordValue()
        );

        return new UserResource($user);
    }
}
