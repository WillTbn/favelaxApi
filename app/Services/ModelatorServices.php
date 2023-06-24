<?php
namespace App\Services;

use App\DataTransferObject\User\UpUserDTO;
use App\DataTransferObject\User\UserDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ModelatorServices
{

    public function getAll()
    {
        $users =  User::whereHas('roles', function ($query) {
            $query->where('name', 'mod');
        })->get();
        return $users;
    }
    public function getOne(int $id)
    {
        $user =  User::whereHas('roles', function ($query) {
            $query->where('name', 'mod');
        })->where('id', $id)->first();

        return $user;
    }

    public function createModelador(UserDTO $mod)
    {

        $user = new User();
        $user->name = $mod->name;
        $user->email = $mod->email;
        $user->password = Hash::make($mod->password);
        $user->saveOrFail();
        return $user;
    }
    public function updateAdmin(UpUserDTO $dto)
    {
        $user = User::where('id', $dto->id)->first();
        $user->name = $dto->name;
        $user->password = Hash::make($dto->password);
        $user->saveOrFail();

        return $user;
    }
    public function VerifyUser(string $id){
        $user = User::find($id);
        return $user;
    }
}
