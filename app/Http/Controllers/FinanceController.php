<?php

namespace App\Http\Controllers;

use App\DataTransferObject\User\UpUserDTO;
use App\DataTransferObject\User\UserDTO;
use App\Models\User;
use App\Services\FinanceServices;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    private FinanceServices $serviceFin;
    public function __construct(
        FinanceServices $finance,
    )
    {
        $this->serviceFin = $finance;
    }

    public function index()
    {
        $nvlOne =  User::whereHas('roles', function ($query) {
            $query->whereHas('abilities', function ($query) {
                $query->where('title', 'Edited registers');
            });
        })->get();
        $nvlTwo =  User::whereHas('roles', function ($query) {
            $query->whereHas('abilities', function ($query) {
                $query->where('title', 'Deleted registers');
            });
        })->get();

        return response()->json(['status'=> '200', 'data' => ['nivel 1' => $nvlOne, 'nivel 2'=> $nvlTwo]], 200);
    }

    public function create(Request $request)
    {
        $dto = new UserDTO(...$request->only(['name', 'email', 'password', 'password_confirm', 'nivel']));

        $user = $this->serviceFin->createfinance($dto);

        return response()->json(['status'=> '200', 'data' => $user], 200);
    }

    public function show(string $id)
    {
        $getUser = User::find($id);
        if($getUser)
        {
            return response()->json(['status'=> '200', 'data' => $getUser], 200);
        }
        return response()->json(['status'=> '400', 'message' => 'Usuário não existente!'], 400);
    }


    public function update(Request $request,string $user)
    {
        $getUser = User::find($user);
        if($getUser){

            $request['id'] = $user;
            $dto = new UpUserDTO(...$request->only(['id','name','password', 'password_confirm']));
            $registro = $this->serviceFin->updateFinance($dto);

            if($registro){
                return response()->json(['status'=> '200', 'message' => 'Dados atualizado com sucesso','data' => $registro], 200);
            }
            return response()->json(['status'=> '500', 'message' => 'OPS!! erro inexperado, tente novamente mais tarde!'], 500);
        }
        return response()->json(['status'=> '400', 'message' => 'Usuário não existente!'], 400);
    }
}
