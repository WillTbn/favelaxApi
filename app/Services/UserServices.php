<?php
namespace App\Services;

use App\DataTransferObject\User\UpUserDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserServices
{
    public function getOne(int $id){

        $user = auth('api')->user()->role == 'admin' ? User::find($id) : User::where('role', 'low')->where('id', $id)->first();

        return $user;

    }
    public function getNotAdmin(){
        // $users = User::where('role', '!=', 'admin')->where('id', '!=',auth('api')->user()->id)->get();
        $users = User::where('role', '!=', 'admin')->get();

        return $users;
    }
    public function updateUser(UpUserDTO $dto)
    {
        $user = User::where('id', $dto->id)->first();
        $user->name = $dto->name;
        $user->password = Hash::make($dto->password);
        $user->saveOrFail();

        return $user;
    }
}
