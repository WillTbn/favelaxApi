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
    public function createfinance(UserDTO $fin)
    {

        $user = new User();
        $user->name = $fin->name;
        $user->email = $fin->email;
        $user->password = Hash::make($fin->password);
        $user->saveOrFail();
        if($fin->financeNvl && $fin->financeNvl == 1){

        }else if($fin->financeNvl && $fin->financeNvl == 2){


        }
        return $user;
    }
    public function updateFinance(UpUserDTO $dto)
    {
        $user = User::where('id', $dto->id)->first();
        $user->name = $dto->name;
        $user->password = Hash::make($dto->password);
        $user->saveOrFail();

        return $user;
    }
}
