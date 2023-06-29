<?php
namespace App\Services;

use App\DataTransferObject\Admin\AdminDTO;
use App\DataTransferObject\Admin\UpAdminDTO;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class FinancialServices
{
    public function getOne(int $id)
    {
        $financial =  Admin::whereHas('role', function ($query) {
            $query->whereIn('name', ['Financial lvl one', 'Financial lvl two']);
        })->where('id', $id)->first();

        return $financial;
    }
    public function onlyTrashedAll()
    {

        $financial = Admin::onlyTrashed()->whereHas('role', function ($query) {
            $query->whereIn('name', ['Financial lvl one', 'Financial lvl two']);
        })->get();

        return $financial;
    }
    public function onlyTrashed(int $id)
    {

        $financial = Admin::onlyTrashed()->whereHas('role', function ($query) {
            $query->whereIn('name', ['Financial lvl one', 'Financial lvl two']);
        })->where('id', $id)->first();

        return $financial;
    }
    public function getAll()
    {
        $financials =  Admin::where('role_id', 3)->orWhere('role_id', 4)->get();

        return $financials;
    }
    public function createfinance(AdminDTO $fin)
    {

        $financial = new Admin();
        $financial->name = $fin->name;
        $financial->email = $fin->email;
        $financial->password = Hash::make($fin->password);
        $financial->role_id = $fin->role_id;
        $financial->saveOrFail();
        return $financial;
    }
    public function updateFinance(UpAdminDTO $dto)
    {


        $financial = Admin::where('role_id', 3)->orWhere('role_id', 4)->where('id', $dto->id)->first();
        $financial->name = $dto->name;
        $financial->password = Hash::make($dto->password);
        $financial->role_id = $dto->role_id;
        $financial->saveOrFail();

        return $financial;
    }
}
