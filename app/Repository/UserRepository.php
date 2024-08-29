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

    public function checkIfUserEmailExists(string $email){
        return $this->model->where('email',$email)->first();
    }

    
    public function checkIfUserNameExists(string $name){
        return $this->model->where('name',$name)->first();
    }
}
