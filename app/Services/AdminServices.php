<?php
namespace App\Services;

use App\DataTransferObject\admin\AdminDTO;
use App\DataTransferObject\admin\UpAdminDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Silber\Bouncer\BouncerFacade;

class AdminServices
{

    public function getOne(int $id)
    {
        $user =  User::whereHas('roles', function ($query) {
            $query->whereHas('abilities', function ($query) {
                $query->where('name', 'control-all');
            });
        })->where('id', $id)->first();

        return $user;
    }
    public function getAdmins()
    {
        $users =  User::whereHas('roles', function ($query) {
            $query->whereHas('abilities', function ($query) {
                $query->where('name', 'control-all');
            });
        })->get();

        return $users;
    }

    public function createAdmin(AdminDTO $admin)
    {

        $user = new User();
        $user->name = $admin->name;
        $user->email = $admin->email;
        $user->password = Hash::make($admin->password);
        $user->saveOrFail();
        BouncerFacade::assign('admin')->to($user);
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
