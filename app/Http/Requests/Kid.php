<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class Kid extends FormRequest
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
        if (empty(intval($this->route()->parameter('client'))) && auth()->user()->type > 5) {
            $rules =  [
                'name' => ['required', 'string', 'max:191'],
                'identificator' => ['required', 'string', 'min:10', 'max:10'],
                'active' => ['required', 'boolean'],
                'responsable1_name' => ['required', 'string'],
                'responsable1_phone' => ['required', 'string'],
                'responsable2_name' =>  ['required', 'string'],
                'responsable2_phone' => ['required', 'string'],
                'photo' => ['image', 'max:2000', 'min:4', 'mimes:png,jpeg,jpg'],
                'id_kid_class' =>  ['required', 'integer', 'exists:App\Models\KidClass,id'],
                'id_user' =>  ['required', 'integer', 'exists:App\Models\User,id'],
            ];
        } else if (!empty(intval($this->route()->parameter('client'))) && auth()->user()->type < 4) {
            if ($this->request->has('name')) {
                $name = ['required', 'string', 'max:191'];
                $rules['name'] = $name;
            }
            if ($this->request->has('matricula')) {
                $matricula = ['required', 'string', 'max:191'];
                $rules['matricula'] = $matricula;
            }
            if (($this->request->has('active'))) {
                $active = ['required', 'boolean'];
                $rules['active'] = $active;
            }
            if ($this->request->has('responsable1_name')) {
                $responsable1_name = ['required', 'string'];
                $rules['responsable1_name'] = $responsable1_name;
            }
            if ($this->request->has('responsable1_phone')) {
                $responsable1_phone = ['required', 'string'];
                $rules['responsable1_phone'] = $responsable1_phone;
            }
            if ($this->request->has('responsable2_name')) {
                $responsable2_name = ['required', 'string'];
                $rules['responsable2_name'] = $responsable2_name;
            }
            if ($this->request->has('responsable2_phone')) {
                $responsable2_phone = ['required', 'string'];
                $rules['responsable2_phone'] = $responsable2_phone;
            }
            if ($this->hasFile('photo') == true) {
                $photo = ['image', 'max:2000', 'min:4', 'mimes:png,jpeg,jpg'];
                $rules['photo'] = $photo;
            }
            if ($this->request->has('id_kid_class')) {
                $id_kid_class = ['required', 'integer', 'exists:App\Models\KidClass,id'];
                $rules['id_kid_class'] = $id_kid_class;
            }
            if ($this->request->has('id_user')) {
                $id_user = ['required', 'integer', 'exists:App\Models\User,id'];
                $rules['id_user'] = $id_user;
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
            'address.required' => "Informe o endereço",
            'district.required' => "Informe o Bairro",
            'zipcode.required' => "Informe o CEP",
            'number.required' => "Informe o número",
            'phone1.required' => "Informe o telefone",
            'active.required' => "Informe se está ativo ou bloqueado",
            'email.required' => "Informe o Email.",
            'password.required' => "Informe a senha.",
            'id_city.required' => "Selecione uma cidade.",
            'email.email' => "Informe um Email válido",
            'email.unique' => "Uma conta já está cadastrada com esse E-mail",
            'name.max' => "Tamanho máximo de caractere é 120",
            'password.min' => "Sua senha deve ter no mínimo 8 digitos",
            'password.confirmed' => "As senhas digitadas não coincidem",
            'document_type.required' => "Favor selecionar se é pessoa física ou jurídica",
            'document.required' => "Informe o número do documento",
            'document.unique' => "Uma conta já está cadastrada com esse documento",

            'id_city.required' => "Informe o cidade.",
            'id_city.exists' => "Essa cidade não está presente nos registros do banco de dados.",

            'document.cpf' => "Informe o CPF não reconhecido",
            'document.formato_cpf' => "O formato do CPF não é válido",

            'document.cnpj' => "Informe o CNPJ não reconhecido",
            'document.formato_cnpj' => "O formato do CNPJ não é válido",

            'logo.required' => "Selecione um aquivo de imagem",
            'logo.image' => "Selecione um aquivo de imagem",
            'logo.max' => "Tamanho máximo atingido: 2Mb",
            'logo.min' => "Arquivo muito pequeno",
            'logo.mimes' => "Extensão do arquivo não aceita. ",
            'logo.uploaded' => "Tamanho máximo atingido: 2Mb",
        ];
    }
}
