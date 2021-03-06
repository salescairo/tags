<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class User extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
        if (empty(intval($this->route()->parameter('usuario')))) {
            $rules =  [
                'name' => ['required', 'string', 'max:191'],
                'email' => ['required', 'string', 'email', 'max:191', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'type' => ['required', 'string', 'in:default,admin,master'],
                'phone' => ['required', 'string'],
                'active' => ['required'],
            ];
        } else if (!empty(intval($this->route()->parameter('user')))) {
            if ($this->request->has('name')) {
                $name = ['required', 'string', 'max:191'];
                $rules['name'] = $name;
            }
            if ($this->request->has('email')) {
                $email = ['required', 'string', 'email', 'max:191', 'unique:users,'.$this->usuario->id];
                $rules['email'] = $email;
            }
            if ($this->request->has('password')) {
                $password = ['required', 'string', 'min:8', 'confirmed'];
                $rules['password'] = $password;
            }
            if ($this->request->has('type')) {
                $type = ['required', 'in:default,admin,master'];
                $rules['type'] = $type;
            }
            if (($this->request->has('active'))) {
                $active = ['required'];
                $rules['active'] = $active;
            }
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => "Informe o nome.",
            'name.max' => "O tamanho para o nome ?? no m??ximo 191 caracteres.",

            'password.required' => "Informe a senha.",
            'password.min' => "O tamanho para a senha ?? no m??nimo 8 caracteres.",
            'password.confirmed' => "Senhas n??o coincidem.",

            'email.required' => "Informe o email.",
            'email.min' => "O tamanho para o email ?? no m??ximo 191 caracteres.",
            'email.unique' => "J?? existe um registro com esse email cadastrado na base de dados.",

            'type.required' => "Informe o tipo de usu??rio.",
            'type.in' => "Essa op????o est?? indispon??vel para o tipo de usu??rio",

            'active.required' => "Informe se est?? ativo ou bloqueado",
        ];
    }
}
