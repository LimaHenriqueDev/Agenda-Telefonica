<?php

namespace App\Repository;

use App\Models\User;

class UserRepository extends Repository
{
    public function __construct()
    {
        parent::__construct(new User());
    }

    public function getModel()
    {
        return $this->model;
    }
}
