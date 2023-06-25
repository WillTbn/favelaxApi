<?php
namespace App\Services;

use App\DataTransferObject\Finance\FinanceDTO;
use App\DataTransferObject\Finance\UpFinanceDTO;
use App\Enums\Nivel;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FinanceServices
{
    public function getOne(int $id)
    {
        $user = User::where('role', '!=', 'admin')->where('role', '!=', 'modelador')->where('id', $id)->first();

        return $user;
    }
    public function getAll()
    {
        $users =  User::where('role', 'FinanceiroFirst')->orWhere('role', 'FinanceiroSecond')->get();

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
