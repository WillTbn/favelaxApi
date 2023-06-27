<?php
namespace App\Services;

use App\DataTransferObject\admin\AdminDTO;
use App\DataTransferObject\admin\UpAdminDTO;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminServices
{

    public function getOne(int $id)
    {
        $user =  Admin::find($id);

        return $user;
    }
    public function getAdmins()
    {
        $users =  Admin::where('id', '!=',auth('api')->user()->id)->get();

        return $users;
    }

    public function createAdmin(AdminDTO $admin)
    {

        $user = new Admin();
        $user->name = $admin->name;
        $user->email = $admin->email;
        $user->password = Hash::make($admin->password);
        $user->saveOrFail();
        return $user;
    }
    public function updateAdmin(UpAdminDTO $dto)
    {
        $user = Admin::find($dto->id);
        $user->name = $dto->name;
        $user->password = Hash::make($dto->password);
        $user->saveOrFail();

        return $user;
    }
}
