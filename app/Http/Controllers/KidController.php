<?php

namespace App\Http\Controllers;

use App\Repository\Contract\KidInterface;
use Illuminate\Http\Request;
use App\Http\Requests\Kid as KidRequest;
use App\Repository\Contract\KidClassInterface;
use Barryvdh\DomPDF\Facade as PDF;

class KidController extends Controller
{
    public function index(Request $request, KidInterface $interface)
    {
        return response()->view('model.kid.index', ['models' => $interface->all($request)]);
    }

    public function create(Request $request, KidInterface $interface, KidClassInterface $kidClassInterface)
    {
        return response()->view('model.kid.create', [
            'modelKidClass' => $kidClassInterface->all($request),
            'model' => $interface->findLastId()
        ]);
    }
    public function edit(Request $request, $id, KidInterface $interface, KidClassInterface $kidClassInterface)
    {
        $request->all = true;
        return response()->view('model.kid.edit', [
            'modelKidClass' => $kidClassInterface->all($request),
            'model' => $interface->findById($id)
        ]);
    }


    public function store(KidRequest $request, KidInterface $interface, KidClassInterface $kidClassInterface)
    {
        $model = $interface->save($request);
        if ($model == null) {
            return back();
        }
        return redirect()->route('admin.kid.index');
    }

    public function update($id, KidRequest $request, KidInterface $interface, KidClassInterface $kidClassInterface)
    {
        $model = $interface->update($id, $request);
        if ($model == null) {
            return back();
        }
        return redirect()->route('admin.kid.index');
    }

    public function destroy($id, KidInterface $interface)
    {
        $model = $interface->delete($id);
        return redirect()->route('admin.kid.index');
    }
    public function tag(Request $request, KidInterface $interface)
    {
        $request->request->add(['all' => true]);
        return  PDF::loadView('model.kid.tag', ['models' => $interface->all($request)])->setPaper('a4')->setWarnings(false)->stream();
    }
}
