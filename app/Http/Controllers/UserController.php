<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function getDetails()
    {
        // $user = auth('')

        $user = auth('api')->user();
        return 'oi';
        // return $user->getRoles();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        $user = User::create($validatedData);

        // $token = $user->createToken('BearerToken')->accessToken;

        return response()->json(['status' => '200','data' => $user], 200);

    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * List of items in the recycle bin
     * @return \Illuminate\Http\Response
     */
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

        // return response()->json(['error', 'Usuário não se encontra na lista de exclusão!'], 400);
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
