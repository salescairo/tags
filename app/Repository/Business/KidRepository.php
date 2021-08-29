<?php

namespace App\Repository\Business;

use App\Models\Kid;
use App\Repository\Contract\KidInterface;
use App\Repository\Business\AbstractRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class KidRepository extends AbstractRepository implements KidInterface
{
    private $model = Kid::class;
    private $relationships = ['user', 'class'];
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
            if ($this->verifyDuplicity($data->all()) === false) {
                $this->verifyColumns($data->all());
                $model = new Kid();
                $model->name = $data->name;
                $model->identification = $data->identification;
                $model->active = $data->active;
                $model->responsable1_name = $data->responsable1_name;
                $model->responsable1_phone = $data->responsable1_phone;
                $model->responsable2_name = $data->responsable2_name;
                $model->responsable2_phone = $data->responsable2_phone;
                $model->id_kid_class = $data->id_kid_class;
                $model->photo = request()->file('photo')->store('kids');
                $model->id_user = Auth::user()->id;
                $size = getimagesize(request()->file('photo'));
                $width = $size[0];
                $heigh = $size[1];

                $rect = (((($width - ($heigh - (($heigh * 25) / 100))))) <= 0);
                $width2 = $width * 2;
                if ($rect == true && $width2 > $heigh) {
                    $model->save();
                    $this->setMessage("Registro salvo com sucesso", 201);
                    return $model;
                } else {
                    $this->setMessage("Escolha uma foto no formato retrato.", 422);
                }
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
                    if ($data->hasFile('photo') == true) {
                        $photo = request()->file('photo')->store('kids');
                        Storage::delete($model->photo);
                    }
                    $data = $data->all();
                    if ($photo != null) {
                        $data['photo'] = $photo;
                    }
                    $data['id_user'] = Auth::user()->id;
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
                Storage::delete($model->photo);
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
        if (!isset($data->all)) {
            $data->all = false;
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
        if ($data->all = false) {
            $models  = $models->where($search)->orderBy($data->order_by, $data->order)->paginate($data->per_page);
        } else {
            $models  = $models->where($search)->orderBy($data->order_by, $data->order)->get();
        }

        if (count($models) > 0) {
            $this->setMessage("Registro(s) encontrado(s)", 200);
        } else {
            $this->setMessage("Nenhum registro encontrado", 200);
        }
        return $models;
    }
}
