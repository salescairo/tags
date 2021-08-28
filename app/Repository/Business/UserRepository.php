<?php

namespace App\Repository\Business;

use App\Models\User;
use App\Repository\Contract\UserInterface;
use App\Repository\Business\AbstractRepository;

class UserRepository extends AbstractRepository implements UserInterface
{
    private $model = User::class;
    private $relationships = ['kids'];
    private $dependences = [];
    private $unique = ['email'];

    public function __construct()
    {
        $this->model = app($this->model);
        parent::__construct($this->model, $this->relationships, $this->dependences, $this->unique);
    }

}
