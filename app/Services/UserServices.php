<?php
namespace App\Services;

use App\DataTransferObject\User\UpUserDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserServices
{
    public function updateUser(UpUserDTO $dto)
    {
        $user = User::find($dto->id);
        $user->name = $dto->name;
        $user->password = Hash::make($dto->password);
        $user->saveOrFail();

        return $user;
    }
}
