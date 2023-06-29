<?php
namespace App\Services;

use App\DataTransferObject\User\UpUserDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserServices
{
    public function getOne(int $id){

        $user = User::find($id);

        return $user;

    }
    public function getNotAdmin(){
        // $users = User::where('role', '!=', 'admin')->where('id', '!=',auth('api')->user()->id)->get();
        $users = User::all();

        return $users;
    }
    public function updateUser(UpUserDTO $dto)
    {
        $user = User::find($dto->id);
        $user->name = $dto->name;
        $user->password = Hash::make($dto->password);
        $user->saveOrFail();

        return $user;
    }
}
