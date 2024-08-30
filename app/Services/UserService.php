<?php

namespace App\Services;

use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserService
{
  public function __construct(private UserRepository $userRepository) {}

  public function createUser(array $payload): User
  {

    $userData = [
      'name' => $payload['name'],
      'email' => $payload['email'],
      'password' => Hash::make($payload['password']),
    ];

    return  $this->userRepository->create($userData);
  }
}
