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
        $this->loggedUser = auth()->user();
        $this->adminSer = $serviceAdmin;
    }

    public function index()
    {
        $list =  User::whereHas('roles', function ($query) {
            $query->whereHas('abilities', function ($query) {
                $query->where('name', 'control-all');
            });
        })->get();

        return response()->json(['status'=> '200', 'data' => $list], 200);
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // return $request;
        $dto = new AdminDTO(...$request->only(['name', 'email', 'password', 'password_confirm']));
        // $dto->password = Hash::make($dto['password']);
        // return $dto;

        $user = $this->adminSer->createAdmin($dto);

        return response()->json(['status'=> '200', 'data' => $user], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        if($user)
        {
            return response()->json(['status'=> '200', 'data' => $user], 200);
        }
        return response()->json(['status'=> '400', 'message' => 'Usuário não existente!'], 400);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request['id'] = $user->id;
        $dto = new UpAdminDTO(...$request->only(['id','name','password', 'password_confirm']));
        $registro = $this->adminSer->updateAdmin($dto);

        if($registro){
            return response()->json(['status'=> '200', 'message' => 'Dados atualizado com sucesso','data' => $registro], 200);
        }
        return response()->json(['status'=> '500', 'message' => 'OPS!! erro inexperado, tente novamente mais tarde!'], 500);
    }

}
