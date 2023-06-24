<?php

namespace App\Http\Controllers;

use App\DataTransferObject\User\UpUserDTO;
use App\DataTransferObject\User\UserDTO;
use App\Models\User;
use App\Services\ModelatorServices;
use Illuminate\Http\Request;

class ModelatorController extends Controller
{
    private ModelatorServices $modService;
    public function __construct(
        ModelatorServices $serviceMod
    )
    {
        $this->modService = $serviceMod;
    }
    public function index()
    {
        $list =  $this->modService->getAll();

        return response()->json(['status'=> '200', 'data' => $list], 200);
    }

    public function create(Request $request)
    {

        $dto = new UserDTO(...$request->only(['name', 'email', 'password', 'password_confirm']));

        $user = $this->modService->createModelador($dto);

        return response()->json(['status'=> '200', 'data' => $user], 200);
    }

    public function show(string $id)
    {
        $getUser = $this->modService->getOne($id);
        if($getUser){
            return response()->json(['status'=> '200', 'data' => $getUser], 200);
        }
        return response()->json(['status'=> '400', 'message' => 'Usuário não existente na lista de Modeladores.'], 400);
    }

    public function update(Request $request,string $user)
    {
        $getUser = $this->modService->getOne($user);
        if( $getUser ){

            $request['id'] = $user;
            $dto = new UpUserDTO(...$request->only(['id','name','password', 'password_confirm']));
            $registro = $this->modService->updateAdmin($dto);

            if($registro){
                return response()->json(['status'=> '200', 'message' => 'Dados atualizado com sucesso','data' => $registro], 200);
            }
            return response()->json(['status'=> '500', 'message' => 'OPS!! erro inexperado, tente novamente mais tarde!'], 500);
        }
        return response()->json(['status'=> '400', 'message' => 'Usuário não existente, na lista de Modelador!'], 400);
    }
    public function destroy(string $user)
    {
        $currentUser = $this->modService->getOne($user);
        if($currentUser){
            // return $user;
            $getUser = $currentUser->delete();

            return response()->json(['status'=> '200','message' =>  'Usuário adiocinado na lista para ser excluido!', 'data'=>  $getUser], 200 );
        }
        return response()->json(['status'=> '400', 'message' => 'Usuário não existente, na lista de Modelador!'], 400);
    }
}
