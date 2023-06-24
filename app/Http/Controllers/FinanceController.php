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
        $users =  $this->serviceFin->getAll();

        return response()->json(['status'=> '200', 'data'=> $users], 200);
    }

    public function create(Request $request)
    {
        $dto = new UserDTO(...$request->only(['name', 'email', 'password', 'password_confirm', 'nivel']));

        $user = $this->serviceFin->createfinance($dto);

        return response()->json(['status'=> '200', 'data' => $user], 200);
    }

    public function show(string $id)
    {
        $currentUser = $this->serviceFin->getOne($id);
        if($currentUser)
        {
            return response()->json(['status'=> '200', 'data' => $currentUser], 200);
        }
        return response()->json(['status'=> '400', 'message' => 'Usuário não existente no financeiro!'], 400);
    }


    public function update(Request $request,string $user)
    {
        $currentUser = $this->serviceFin->getOne($user);
        if($currentUser){

            $request['id'] = $user;
            $dto = new UpUserDTO(...$request->only(['id','name','password', 'password_confirm']));
            $registro = $this->serviceFin->updateFinance($dto);

            if($registro){
                return response()->json(['status'=> '200', 'message' => 'Dados atualizado com sucesso','data' => $registro], 200);
            }
            return response()->json(['status'=> '500', 'message' => 'OPS!! erro inexperado, tente novamente mais tarde!'], 500);
        }
        return response()->json(['status'=> '400', 'message' => 'Usuário na lista do Financeiro!'], 400);
    }

    public function destroy(string $user)
    {
        $currentUser = $this->serviceFin->getOne($user);
        if($currentUser){

            $getUser = $currentUser->delete();

            return response()->json(['status'=> '200','message' =>  'Usuário adiocinado na lista para ser excluido!', 'data'=>  $getUser], 200 );
        }
        return response()->json(['status'=> '400','message' =>  'Usuário não se encontra na lista do Financeiro!'], 400 );
    }
}
