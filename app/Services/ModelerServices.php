<?php
namespace App\Services;

use App\DataTransferObject\Admin\AdminDTO;
use App\DataTransferObject\Admin\UpAdminDTO;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class ModelerServices
{

    public function getAll()
    {
        $users = Admin::where('role_id', 2)->get();
        return $users;
    }
    public function getOne(int $id)
    {
        $user =  Admin::where(['role_id'=> 2, 'id' => $id])->first();

        return $user;
    }
    public function OnlyTrashedAll()
    {

        $financial = Admin::onlyTrashed()->whereHas('role', function ($query) {
            $query->whereIn('name', ['Modeler']);
        })->get();

        return $financial;
    }
    public function OnlyTrashed(int $id)
    {

        $financial = Admin::onlyTrashed()->whereHas('role', function ($query) {
            $query->whereIn('name', ['Modeler']);
        })->where('id', $id)->first();

        return $financial;
    }
    public function createModelador(AdminDTO $mod)
    {

        $user = new Admin();
        $user->name = $mod->name;
        $user->email = $mod->email;
        $user->password = Hash::make($mod->password);
        $user->role_id = $mod->role_id;
        $user->saveOrFail();
        return $user;
    }
    public function updateAdmin(UpAdminDTO $dto)
    {
        $user =Admin::where('role_id', 2)->where('id', $dto->id)->first();
        $user->name = $dto->name;
        $user->password = Hash::make($dto->password);
        $user->role_id = $dto->role_id;
        $user->saveOrFail();

        return $user;
    }
    public function VerifyUser(string $id){
        $user = Admin::where('role_id', 2)->first($id);
        return $user;
    }
}
