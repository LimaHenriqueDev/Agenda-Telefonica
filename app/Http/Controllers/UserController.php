<?php

namespace App\Http\Controllers;

use App\Exceptions\EmailAlreadyExistsException;
use App\Exceptions\UserNameAlreadyExistsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Services\UserService;
use Illuminate\Http\Response;

class UserController extends Controller
{

    public function __construct(private UserService $userService) {}

    public function store(StoreUserRequest $storeUserRequest)
    {
        try {

            $user = $this->userService->createUser($storeUserRequest->validated());

            return response()->json($user, 201);
        } catch (EmailAlreadyExistsException $e) {
            return response(null, Response::HTTP_CONFLICT);
        } catch (\Exception $e) {
            return $this->apiError($e);
        }
    }
}
