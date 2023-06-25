<?php
namespace App\Services;

use App\DataTransferObject\admin\AdminDTO;
use App\DataTransferObject\admin\UpAdminDTO;
use App\Enums\Nivel;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminServices
{

    public function getOne(int $id)
    {
        $user =  User::where('role', 'admin')->where('id', $id)->first();

        return $user;
    }
    public function getAdmins()
    {
        $users = User::where('role', 'admin')->get();

        return $users;
    }

    public function createAdmin(AdminDTO $admin)
    {

        $user = new User();
        $user->name = $admin->name;
        $user->email = $admin->email;
        $user->password = Hash::make($admin->password);
        $user->role = Nivel::ADMIN->getValue();
        $user->saveOrFail();
        return $user;
    }
    public function updateAdmin(UpAdminDTO $dto)
    {
        $user = User::where('id', $dto->id)->first();
        $user->name = $dto->name;
        $user->password = Hash::make($dto->password);
        $user->saveOrFail();

        return $user;
    }
}
