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
        if (empty(intval($this->route()->parameter('aluno')))) {
            $rules =  [
                'name' => ['required', 'string', 'max:191'],
                'identification' => ['required', 'string', 'min:10', 'max:10'],
                'responsable1_name' => ['required', 'string'],
                'responsable1_phone' => ['required', 'string'],
                'responsable2_name' =>  ['required', 'string'],
                'responsable2_phone' => ['required', 'string'],
                'photo' => ['image', 'max:7000', 'min:4', 'mimes:png,jpeg,jpg'],
                'id_kid_class' =>  ['required', 'integer', 'exists:App\Models\KidClass,id'],
            ];
        } else {
            if ($this->request->has('name')) {
                $name = ['required', 'string', 'max:191'];
                $rules['name'] = $name;
            }
            if ($this->request->has('identificator')) {
                $identificator = ['required', 'string', 'min:10', 'max:10'];
                $rules['identificator'] = $identificator;
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
            'identification.required' => "Informe a RM",
            'identification.min' => "Verifique a RM,Quantidade de dígitos tem que ser igual a 10)",
            'identification.max' => "Verifique a RM,Quantidade de dígitos tem que ser igual a 10)",
            'identification.required' => "Informe a RM",
            'responsable1_name.required' => "Informe o Bairro",
            'responsable1_name.required' => "Informe o CEP",
            'responsable2_name.required' => "Informe o número",
            'responsable1_phone.required' => "Informe o telefone",
            'responsable2_phone.required' => "Informe se está ativo ou bloqueado",

            'id_kid_class.required' => "Informe a turma.",
            'id_kid_class.exists' => "Essa turma não está presente nos registros do banco de dados.",


            'photo.required' => "Selecione um aquivo de imagem",
            'photo.image' => "Selecione um aquivo de imagem",
            'photo.max' => "Tamanho máximo atingido: 2Mb",
            'photo.min' => "Arquivo muito pequeno",
            'photo.mimes' => "Extensão do arquivo não aceita. ",
            'photo.uploaded' => "Tamanho máximo atingido: 2Mb",
        ];
    }
}
