<?php

namespace App\Http\Controllers;

use App\Repository\Contract\KidClassInterface;
use Illuminate\Http\Request;
use App\Http\Requests\KidClass as KidClassRequest;
use App\Models\KidClass;

class KidClassController extends Controller
{

    public function index(Request $request, KidClassInterface $interface)
    {
        return response()->view('model.kidClass.index', ['models' => $interface->all($request)]);
    }

    public function create(Request $request, KidClassInterface $interface)
    {
        return response()->view('model.kidClass.create', ['model' => $interface->findLastId()]);
    }
    public function edit($id, KidClassInterface $interface)
    {
        return response()->view('model.kidClass.edit', ['model' => $interface->findById($id)]);
    }


    public function store(KidClassRequest $request, KidClassInterface $interface)
    {
        $model =  $interface->save($request);
        if ($model == null) {
            return back();
        }
        return redirect()->route('admin.kid.class.index');
    }

    public function update($id, KidClassRequest $request, KidClassInterface $interface)
    {
        $model = $interface->update($id, $request);
        if ($model == null) {
            return back();
        }
        return redirect()->route('admin.kid.class.index');
    }

    public function destroy($id, KidClassInterface $interface)
    {
        $model = $interface->delete($id);
        return redirect()->route('admin.kid.class.index');
    }
}
