<?php

namespace App\Http\Controllers;

use App\DataTransferObject\Admin\AdminDTO;
use App\DataTransferObject\Admin\UpAdminDTO;
use App\DataTransferObject\Modeler\ModelerDTO;
use App\DataTransferObject\Modeler\UpModelerDTO;
use App\Models\Admin;
use App\Models\Modeler;
use App\Services\ModelerServices;
use Illuminate\Http\Request;

class ModelerController extends Controller
{
    private ModelerServices $modService;
    public function __construct(
        ModelerServices $serviceMod
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
        $request['role_id'] = 2;
        $dto = new AdminDTO(...$request->only(['name', 'email', 'password', 'password_confirm', 'role_id']));

        $user = $this->modService->createModelador($dto);

        return response()->json(['status'=> '200', 'message'=>'Modelador criado com sucesso!','data' => $user], 200);
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
            $dto = new UpAdminDTO(...$request->only(['id','name','password', 'password_confirm', 'role_id']));
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
    public function trashed()
    {
        $users = $this->modService->OnlyTrashedAll();

        return response()->json(['status'=> '200','message' =>  'Lista de usuários para exclusão!', 'data'=>  $users], 200 );
    }
    public function restore(string $id)
    {

        $getUser = $this->modService->OnlyTrashed($id);
        if($getUser){
            $getUser->restore();
            return response()->json(['status'=> '200', 'Usuário foi retirado da lista de exclusão!','data'=> $getUser], 200 );
        }

        return response()->json(['status'=>'200','message'=>'Usuário não se encontra na lista de exclusão!'], 400);
    }


    public function deleteForce(string $id)
    {
        $getUser = $this->modService->OnlyTrashedAll($id);
        if($getUser)
        {
            $getUser->forceDelete();

            return response()->json(['status'=> '200','message'=> 'Usuario excluido do sistema!'], 200);
        }
        return response()->json(['status'=>'400', 'message' =>'Usuário não se encontra na lista de exclusão!'], 400);
    }
}
