<?php

namespace App\DataTransferObject\Admin;

use App\DataTransferObject\AbstractDTO;
use App\DataTransferObject\InterfaceDTO;
use Illuminate\Contracts\Validation\Validator;
class AdminDTO extends AbstractDTO implements InterfaceDTO
{
    public readonly string $name;
    public readonly string $email;
    public readonly string $password;
    public readonly string $password_confirm;
    public readonly string $role_id;

    public function __construct(
        ?string $name  = null,
        ?string $email = null,
        ?string $password = null,
        ?string $password_confirm = null,
        ?string $role_id = null
    )
    {
        $this->name = $name ?? '';
        $this->email = $email ?? '';
        $this->password = $password ?? '';
        $this->password_confirm = $password_confirm ?? '';
        $this->role_id = $role_id ?? '';
        $this->validate();
    }
    public function rules():array
    {
        return [
            'name' => 'required|string|min:4|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:8',
            'password_confirm' =>'required|same:password',
            'role_id' =>'required|string|exists:roles,id'
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
            'password_confirm.same' => "O campo de confirmação de senha deve corresponder à senha.",
            'exists'=>'O :attribute não reconhecido em nosso sistema!'
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
