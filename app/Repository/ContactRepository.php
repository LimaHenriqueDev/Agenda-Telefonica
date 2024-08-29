<?php

namespace App\Repository;

use App\Models\Contact;

class ContactRepository extends Repository
{
    public function __construct()
    {
        parent::__construct(new Contact());
    }

    public function getModel()
    {
        return $this->model;
    }

    public function checkIfContactEmailExists(string $email){
        return $this->model->where('email',$email)->first();
    }

}
