<?php
namespace App\Services;

use App\DataTransferObject\Finance\FinanceDTO;
use App\DataTransferObject\Finance\UpFinanceDTO;
use App\Models\Financial;
use Illuminate\Support\Facades\Hash;

class FinancialServices
{
    public function getOne(int $id)
    {

        $financial =  Financial::find($id);

        return $financial;
    }
    public function getAll()
    {
        $financials =  Financial::get();

        return $financials;
    }
    public function createfinance(FinanceDTO $fin)
    {

        $financial = new Financial();
        $financial->name = $fin->name;
        $financial->email = $fin->email;
        $financial->password = Hash::make($fin->password);
        $financial->level = $fin->level;
        $financial->saveOrFail();
        return $financial;
    }
    public function updateFinance(UpFinanceDTO $dto)
    {


        $financial = Financial::where('id', $dto->id)->first();
        $financial->name = $dto->name;
        $financial->password = Hash::make($dto->password);
        // qualquer outro valor passado irá se considerado nivel 1 para o financeiro
        $financial->level = $dto->level;
        $financial->saveOrFail();

        return $financial;
    }
}
