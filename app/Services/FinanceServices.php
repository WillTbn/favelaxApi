<?php
namespace App\Services;

use App\DataTransferObject\User\UpUserDTO;
use App\DataTransferObject\User\UserDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Silber\Bouncer\BouncerFacade;

class FinanceServices
{
    public function getOne(int $id)
    {

        $user =  User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'admin')->orWhere('name', 'mod');
        })->where('id', $id)->first();


        return $user;
    }
    public function getAll()
    {
        $users =  User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'admin')->orWhere('name', 'mod');
        })->get();

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
            BouncerFacade::assign('financNvlOne')->to($user);
        }else if($fin->financeNvl && $fin->financeNvl == 2){

            BouncerFacade::assign('financNvlTwo')->to($user);
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
