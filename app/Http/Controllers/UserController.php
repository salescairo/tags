<?php

namespace App\Http\Controllers;

use App\Repository\Contract\UserInterface;
use Illuminate\Http\Request;
use App\Http\Requests\User as UserRequest;

class UserController extends Controller
{

    public function index(Request $request, UserInterface $interface)
    {
        return response()->view('model.user.index', ['models' => $interface->all($request)]);
    }

    public function create(Request $request, UserInterface $interface)
    {
        return response()->view('model.user.create', ['model' => $interface->findLastId()]);
    }
    public function edit($id, UserInterface $interface)
    {
        return response()->view('model.user.edit', ['model' => $interface->findById($id)]);
    }


    public function store(UserRequest $request, UserInterface $interface)
    {
        return response()->view('model.user.create', [
            'model' => $interface->save($request),
            'message' => $interface->getMessage()->text
        ]);
    }

    public function update($id, UserRequest $request, UserInterface $interface)
    {
        $model = $interface->update($id, $request);
        if ($model == null) {
            return back();
        }
        return redirect()->route('admin.user.index');
    }

    public function destroy($id, UserInterface $interface)
    {
        $model = $interface->delete($id);
        return redirect()->route('admin.user.index');
    }
}
