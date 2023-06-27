<?php
namespace App\Services;

use App\DataTransferObject\User\UpUserDTO;
use App\DataTransferObject\User\UserDTO;
use App\Models\Financial;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FinanceServices
{
    public function getOne(int $id)
    {

        $user =  Financial::find($id);


        return $user;
    }
    public function getAll()
    {
        $users =  Financial::get();

        return $users;
    }
    public function createfinance(FinanceDTO $fin)
    {

        $user = new User();
        $user->name = $fin->name;
        $user->email = $fin->email;
        $user->password = Hash::make($fin->password);
        $user->role = $fin->nivel === "2"  ? Nivel::SECOND->getValue() : Nivel::FIRST->getValue();
        $user->saveOrFail();
        return $user;
    }
    public function updateFinance(UpFinanceDTO $dto)
    {


        $user = User::where('id', $dto->id)->first();
        $user->name = $dto->name;
        $user->password = Hash::make($dto->password);
        // qualquer outro valor passado irá se considerado nivel 1 para o financeiro
        $user->role = $dto->nivel === "2"  ? Nivel::SECOND->getValue() : Nivel::FIRST->getValue();
        $user->saveOrFail();

        return $user;
    }
}
