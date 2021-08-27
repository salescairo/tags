<?php

namespace App\Repository\Business;

use App\Models\Kid;
use App\Models\KidClass;
use App\Repository\Contract\KidClassInterface;
use App\Repository\Business\AbstractRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

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


    public function save(Request $data)
    {
        try {
            if (!$this->verifyDuplicity($data->all())) {
                $this->verifyColumns($data->all());
                $data = $data->all();
                $this->model->create($data);
                $this->setMessage("Registro salvo com sucesso", 201);
                return $this->model;
            } else {
                $this->setMessage("Registro já existente", 422);
            }
        } catch (\Exception $ex) {
            $this->setMessage($ex->getMessage(), 500);
        }
        return null;
    }

    public function update($id, Request $data)
    {
        $model = $this->model->find($id);
        if (!empty($model)) {
            try {
                if (!$this->verifyDuplicity($data->all(), $id)) {
                    $photo = null;
                    $data = $data->all();
                    $model->update($data);
                    $this->setMessage("Registro atualizado com sucesso", 200);
                    return $model;
                } else {
                    $this->setMessage("Registro já existente", 422);
                }
            } catch (\Exception $ex) {
                $this->setMessage($ex->getMessage(), 500);
            }
        } else {
            $this->setMessage("Registro não encontrado", 404);
        }
        return null;
    }


    public function findById($id)
    {
        $model = $this->model->with($this->relationships)->find($id);
        if (!empty($model)) {

            $this->setMessage("Registro encontrado", 200);
            return $model;
        }
        $this->setMessage("Registro não encontrado", 404);
        return null;
    }
    public function findLastId()
    {
        $model = $this->model->with($this->relationships)->orderBy('id', 'desc')->first();
        if (!empty($model)) {

            $this->setMessage("Registro encontrado", 200);
            return $model;
        }
        $this->setMessage("Registro não encontrado", 404);
        return null;
    }

    public function delete($id)
    {
        $model = $this->model->find($id);
        if (!empty($model)) {
            $dependence = $this->verifyDependences($model);
            if ($dependence === true) {
                $model->destroy($model->id);
                $this->setMessage("Registro apagado com sucesso", 200);
            } else {
                $this->setMessage($dependence, 403);
            }
        } else {
            $this->setMessage("Registro não encontrado", 404);
        }
        return null;
    }



    public function all(Request $data)
    {
        $models = null;
        //ENABLE PAGAINATION
        if (!isset($data->per_page)) {
            $data->per_page =  25;
        } else {
            $data->per_page = filter_var($data->per_page, FILTER_VALIDATE_INT);
        }

        if ($data->per_page > 100) {
            $data->per_page = 100;
        } else if ($data->per_page < 10) {
            $data->per_page = 10;
        }


        if (!isset($data->page)) {
            $data->page = 0;
        }


        //ORDER
        if (!isset($data->order_by)) {
            $data->order_by = 'id';
        }
        if (!Arr::exists($this->model->getFillable(), $data->order_by)) {
            $data->order_by  = "id";
        }


        if (!isset($data->order)) {
            $data->order = 'asc';
        } else {
            $data->order = ($data->order == 'desc' ? 'desc' : 'asc');
        }

        $models = $this->model->query()->with($this->relationships);
        $search = [];
        foreach ($data as $column => $value) {
            if (Schema::hasColumn($this->model->getTable(), $column)) {
                $type = null;
                $type = Schema::getColumnType($this->model->getTable(), $column);
                if ($type == "string" || $type == "datetime") {
                    array_push($search, [$column, 'like', "%" . $value . "%"]);
                } else {
                    array_push($search, [$column, $value]);
                }
            }
        }
        if (isset($data->search) && $data->search != null && empty($search)) {
            $columns = null;
            $columns = Schema::getColumnListing($this->model->getTable());
            foreach ($columns as $column) {
                $models->orWhere($column, 'LIKE', '%' . $data->search . '%');
            }
        }
        $models  = $models->where($search)->orderBy($data->order_by, $data->order)->paginate($data->per_page);

        if (count($models) > 0) {
            $this->setMessage("Registro(s) encontrado(s)", 200);
        } else {
            $this->setMessage("Nenhum registro encontrado", 200);
        }
        return $models;
    }
}
