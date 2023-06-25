<?php

namespace App\DataTransferObject\Finance;

use App\DataTransferObject\AbstractDTO;
use App\DataTransferObject\InterfaceDTO;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class UpFinanceDTO extends AbstractDTO implements InterfaceDTO
{
    public readonly string $name;
    public readonly string $password;
    public readonly string $password_confirm;
    public readonly string $nivel;
    public readonly string $id;
    public function __construct(
        ?string $name = null,
        ?string $password = null,
        ?string $password_confirm = null,
        ?string $nivel = null,
        ?string $id = null,
    )
    {
        $this->name = $name ?? '';
        $this->password = $password ?? '';
        $this->password_confirm = $password_confirm ?? '';
        $this->nivel = $nivel ?? '';
        $this->id = $id ?? '';
        $this->validate();
    }
    public function rules():array
    {
        return [
            'name' => 'required|string|min:4|max:255',
            'password' => 'required|string|min:8',
            'password_confirm' =>'required|same:password',
            'nivel' => 'required|max:1',
            'id' => 'required'
        ];
    }
    public function messages():array
    {
        return [
            'required' => 'O :attribute é obrigatório!',
            'string' => 'Campo :attribute só aceitar texto.',
            'max' => 'Limite máximo de caracteres ultrapassada no campo :attribute.',
            'min'=> 'Minimo de caracteres não atigindo, no campo :attribute.',
            'email' => 'O campo de e-mail deve ser um endereço de e-mail válido.',
            'unique' => 'O campo :attribute já esta cadastrado em nosso sistema.',
            'password_confirm.same' => "O campo de confirmação de senha deve corresponder à senha."
        ];
    }
    public function validator():Validator
    {
        return validator($this->toArray(), $this->rules(), $this->messages());
    }

    public function validate():array
    {
        return $this->validator()->validate();
    }
}
