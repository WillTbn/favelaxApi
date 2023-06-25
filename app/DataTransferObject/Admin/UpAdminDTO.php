<?php

namespace App\DataTransferObject\Admin;

use App\DataTransferObject\AbstractDTO;
use App\DataTransferObject\InterfaceDTO;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class UpAdminDTO extends AbstractDTO implements InterfaceDTO
{
    public readonly string $name;
    public readonly int $id;
    public readonly string $password;
    public readonly string $password_confirm;

    public function __construct(
        ?int $id = null,
        ?string $name = null,
        // public readonly string $email,
       ?string $password = null,
       ?string $password_confirm = null
    )
    {
        $this->id = $id ?? '';
        $this->name = $name ?? '';
        $this->password = $password ?? '';
        $this->password_confirm = $password_confirm ?? '';
        $this->validate();
    }
    public function rules():array
    {
        return [
            'id' => 'required',
            'name' => 'required|string|min:4|max:255',
            // 'email' => [
                //     'required', 'string','email','max:255',
                //     Rule::unique('user')->ignore($this->id)
                // ],
            'password' => 'required|string|min:8',
            'password_confirm' =>'required|same:password',
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
