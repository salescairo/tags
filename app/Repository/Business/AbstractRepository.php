<?php

namespace App\Repository\Business;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;
use stdClass;

abstract class AbstractRepository
{
    private $model;
    private $relationships;
    private $dependences;
    private $unique;
    private $message;

    public function __construct($model, $relationships, $dependences, $unique)
    {
        $this->model = $model;
        $this->relationships = $relationships;
        $this->dependences = $dependences;
        $this->unique = $unique;
        $this->message = new stdClass();
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

    public function save(Request $data)
    {
        try {
            $this->verifyColumns($data->all());
            if (!$this->verifyDuplicity($data->all())) {
                $model = $this->model->create($data->all());
                $this->setMessage("Registro salvo com sucesso", 200);
                return $model;
            } else {
                $this->setMessage("Registro já existente", 422);
            }
        } catch (\Exception $ex) {
            $this->setMessage($ex->getMessage(), 403);
        }
        return null;
    }
    public function update($id, Request $data)
    {
        $model = $this->model->find($id);
        if (!empty($model)) {
            try {
                $this->verifyColumns($data->all());
                if (!$this->verifyDuplicity($data->all(), $id)) {
                    $model->update($data->all());
                    $this->setMessage("Registro atualizado com sucesso", 200);
                    return $model;
                } else {
                    $this->setMessage("Registro já existente", 422);
                }
            } catch (\Exception $ex) {
                $this->setMessage($ex->getMessage(), 403);
            }
        } else {
            $this->setMessage("Registro não encontrado", 404);
        }
        return null;
    }

    public function getMessage()
    {
        return $this->message;
    }



    /**
     * Dependences
     * Relationships
     * Filters fly
     *
     */
    protected function setMessage($text, $code)
    {
        $this->message->text = $text;
        $this->message->code = $code;
    }

    protected function verifyColumns($data)
    {
        foreach ($data as $column) {
            if (!Schema::hasColumn($this->model->getTable(), $column)) {
                //unset($data[$column]);
            }
        }
    }


    protected function verifyDependences($model)
    {
        $model = $this->model->with($this->dependences)->find($model->id);
        if (!empty($model)) {
            $dependences_collection = [];
            foreach ($this->dependences as $dependence) {
                if (!empty($model->$dependence[0])) {
                    array_push($dependences_collection, $dependence);
                }
            }

            if (!empty($dependences_collection)) {
                $message = "O item não pode ser deletado pois depende de: ";
                $count = 0;
                foreach ($dependences_collection as $dependence) {
                    if ($count == 0 && count($dependences_collection) == 1) {
                        $message = $message . "" . $model->$dependence[0]->title;
                    } else if ($count == 0 && $count < count($dependences_collection)) {
                        $message = $message . "" . $model->$dependence[0]->title;
                    } else if ($count === (count($dependences_collection) - 1)) {
                        $message = $message . " e " . $model->$dependence[0]->title;
                    } else {
                        $message = $message . ", " . $model->$dependence[0]->title;
                    }
                    $count++;
                }
                return $message;
            }
            return true;
        }
        return true;
    }

    protected function  verifyDuplicity($data, $id = null)
    {
        $columns = $this->unique;
        if (empty($this->unique)) return false;
        $models = $this->model->query();
        $count = 0;
        foreach ($columns as $column) {
            if (!empty($data[$column])) {
                if (Schema::hasColumn($this->model->getTable(), $column)) {
                    $models->where($column, $data[$column]);
                    $count++;
                }
            }
        }
        if ($id != null) {
            $models->where('id', '!=', $id);
        }

        if (count($models->get()) > 0 && count($columns) == $count) {
            return true;
        }
        return false;
    }



    /**
     * FUNÇÃO PARA VERIFICAR ACESSOS PARA VER
     *
     *
     *
     */

    protected function verifyContractManager()
    {
    }
    /**
     * FUNÇÃO PARA VERIFICAR ACESSOS PARA VER
     *
     */
    protected function verifyContractManager1()
    {
    }
}
