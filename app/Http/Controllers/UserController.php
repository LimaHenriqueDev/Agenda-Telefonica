<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Services\UserService;

class UserController extends Controller
{

    public function __construct(private UserService $userService) {}

    public function store(StoreUserRequest $storeUserRequest)
    {
        try {
            $user = $this->userService->createUser($storeUserRequest->validated());

            return response()->json($user, 201);
        } catch (\Exception $e) {
            return $this->apiError($e);
        }
    }}