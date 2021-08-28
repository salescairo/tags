<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class KidClass extends FormRequest
{

    /**
     * Autoriza o reconhecimento da validação.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth()->check();
    }
    /**
     * Regras de validação para os campos do formulário de inserir cliente.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
        if (empty(intval($this->route()->parameter('turma')))) {
            $rules =  [
                'name' => ['required', 'string', 'max:191'],
                'time' => ['required', 'in:Manhã, Tarde'],
            ];
        } else{
            if ($this->request->has('name')) {
                $name = ['required', 'string', 'max:191'];
                $rules['name'] = $name;
            }
            if ($this->request->has('time')) {
                $time = ['required', 'in:Manhã, Tarde'];
                $rules['time'] = $time;
            }
            if (($this->request->has('active'))) {
                $active = ['required', 'boolean'];
                $rules['active'] = $active;
            }
        }
        return $rules;
    }

    /**
     * Retorno das mensagens de validação do formulário de inserir cliente.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => "Informe o nome.",
            'active.required' => "Informe se está ativo ou bloqueado",
        ];
    }
}
