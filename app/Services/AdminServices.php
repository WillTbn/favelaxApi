<?php
namespace App\Services;

use App\DataTransferObject\admin\AdminDTO;
use App\DataTransferObject\admin\UpAdminDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Silber\Bouncer\BouncerFacade;

class AdminServices
{
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
