<?php

namespace App\Http\Controllers;

use App\DataTransferObject\User\UpUserDTO;
use App\Models\User;
use App\Services\UserServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private UserServices $userServ;
    public function __construct(
        UserServices $serviceUser
    )
    {
        $this->middleware('auth:api');
        $this->userServ = $serviceUser;
    }
    public function index()
    {
        $type = auth('api')->user()->role;
        // return dd($userCurrent[0]);
        if($type == "modelador"){
            $users = $this->userServ->getNotAdmin();
        }else{
            $users = User::all();
        }

        return response()->json(['status' => '200', 'data' =>  $users], 200);
    }


    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'password_confirm' => 'required|string|min:8|same:password',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        $user = User::create($validatedData);

        return response()->json(['status' => '200', 'message'=>'Usuário criado com sucesso!','data' => $user], 200);

    }

    public function update(Request $request, string $user)
    {
        $getUser = $this->userServ->getOne($user);

        // return $getUser;
        if($getUser){
            $request['id'] = $getUser->id;
            $dto = new UpUserDTO(...$request->only(['id','name','password', 'password_confirm']));
            $registro = $this->userServ->updateUser($dto);

            if($registro){
                return response()->json(['status'=> '200', 'message' => 'Dados atualizado com sucesso','data' => $registro], 200);
            }
            return response()->json(['status'=> '500', 'message' => 'OPS!! erro inexperado, tente novamente mais tarde!'], 500);
        }
        return response()->json(['status'=> '400', 'message' => 'Usuário não encontrado!'], 400);
    }


    public function trashed()
    {
        $users = User::onlyTrashed()->get();

        return response()->json(['status'=> '200','message' =>  'Lista de usuários para exclusão!', 'data'=>  $users], 200 );
    }
    public function restore(string $id)
    {

        $getUser = User::onlyTrashed()->where(['id' => $id])->first();
        if($getUser){
            $getUser->restore();
            return response()->json(['status'=> '200', 'Usuário foi retirado da lista de exclusão!','data'=> $getUser], 200 );
        }

        return response()->json(['error', 'Usuário não se encontra na lista de exclusão!'], 400);
    }
    public function destroy(User $user)
    {
        if($user)
        {
            // return $user;
            $getUser = $user->delete($user->id);

            return response()->json(['status'=> '200','message' =>  'Usuário adiocinado na lista para ser excluido!', 'data'=>  $getUser], 200 );
        }
    }


    public function deleteForce(string $id)
    {
        $getUser = User::onlyTrashed()->where(['id' => $id])->first();
        if($getUser)
        {
            $getUser->forceDelete();

            return response()->json(['status'=> '200','message'=> 'Usuario excluido do sistema!'], 200);
        }
        return response()->json(['status'=>'400', 'message' =>'Usuário não se encontra na lista de exclusão!'], 400);
    }
}
