<?php
namespace App\Services;

use App\DataTransferObject\User\UpUserDTO;
use App\DataTransferObject\User\UserDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Silber\Bouncer\BouncerFacade;

class ModelatorServices
{
    public function createModelador(UserDTO $mod)
    {

        $user = new User();
        $user->name = $mod->name;
        $user->email = $mod->email;
        $user->password = Hash::make($mod->password);
        $user->saveOrFail();
        BouncerFacade::assign('mod')->to($user);
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
