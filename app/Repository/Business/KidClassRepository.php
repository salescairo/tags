<?php

namespace App\Repository\Business;

use App\Models\KidClass;
use App\Repository\Contract\KidClassInterface;
use App\Repository\Business\AbstractRepository;

class KidClassRepository extends AbstractRepository implements KidClassInterface
{
    private $model = KidClass::class;
    private $relationships = ['kids'];
    private $dependences = [];
    private $unique = ['identification'];

    public function __construct()
    {
        $this->model = app($this->model);
        parent::__construct($this->model, $this->relationships, $this->dependences, $this->unique);
    }

}
