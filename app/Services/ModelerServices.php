<?php
namespace App\Services;

use App\DataTransferObject\Modeler\ModelerDTO;
use App\DataTransferObject\Modeler\UpModelerDTO;
use App\Models\Modeler;
use Illuminate\Support\Facades\Hash;

class ModelerServices
{

    public function getAll()
    {
        $users = Modeler::all();
        return $users;
    }
    public function getOne(int $id)
    {
        $user =  Modeler::find($id);

        return $user;
    }

    public function createModelador(ModelerDTO $mod)
    {

        $user = new Modeler();
        $user->name = $mod->name;
        $user->email = $mod->email;
        $user->password = Hash::make($mod->password);
        $user->saveOrFail();
        return $user;
    }
    public function updateAdmin(UpModelerDTO $dto)
    {
        $user = Modeler::where('id', $dto->id)->first();
        $user->name = $dto->name;
        $user->password = Hash::make($dto->password);
        $user->saveOrFail();

        return $user;
    }
    public function VerifyUser(string $id){
        $user = Modeler::find($id);
        return $user;
    }
}
