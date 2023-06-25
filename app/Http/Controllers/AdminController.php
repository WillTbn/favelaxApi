<?php

namespace App\Http\Controllers;

use App\DataTransferObject\Admin\AdminDTO;
use App\DataTransferObject\Admin\UpAdminDTO;
use App\Models\User;
use App\Services\AdminServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    private $loggedUser;
    private AdminServices $adminSer;
    public function __construct(
        AdminServices $serviceAdmin
    )
    {
        $this->middleware('auth:api');
        $this->loggedUser = auth()->user('api');
        $this->adminSer = $serviceAdmin;
    }

    public function index()
    {
        $list = $this->adminSer->getAdmins();

        return response()->json(['status'=> '200', 'data' => $list], 200);
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // return $request;
        $dto = new AdminDTO(...$request->only([
            'name', 'email', 'password', 'password_confirm'
        ]));
        // $dto->password = Hash::make($dto['password']);
        // return $dto;

        $user = $this->adminSer->createAdmin($dto);

        return response()->json(['status'=> '200', 'data' => $user], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $user)
    {
        $getUser = $this->adminSer->getOne($user);
        if($getUser)
        {
            return response()->json(['status'=> '200', 'data' => $getUser], 200);
        }
        return response()->json(['status'=> '400', 'message' => 'Usuário não existente na lista de adm!'], 400);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $user)
    {
        $request['id'] = $user;
        $getUser = $this->adminSer->getOne($user);
        if($getUser){
            $dto = new UpAdminDTO(...$request->only(['id','name','password', 'password_confirm']));
            $registro = $this->adminSer->updateAdmin($dto);

            if($registro){
                return response()->json(['status'=> '200', 'message' => 'Dados atualizado com sucesso','data' => $registro], 200);
            }
            return response()->json(['status'=> '500', 'message' => 'OPS!! erro inexperado, tente novamente mais tarde!'], 500);
        }
        return response()->json(['status'=> '400', 'message' => 'Usuário não existente na lista de adm!'], 400);
    }
    public function destroy(string $user)
    {
        $currentUser =  $user = $this->adminSer->getOne($user);
        if($currentUser){

            $getUser = $currentUser->delete($currentUser->id);

            return response()->json(['status'=> '200','message' =>  'Usuário adiocinado na lista para ser excluido!', 'data'=>  $getUser], 200 );
        }
        return response()->json(['status'=> '400','message' =>  'Usuário não se encontra na lista de Admin!'], 400 );
    }

}
