<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminLoginController extends Controller
{
    public function adminLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){

            return response()->json(['error' => $validator->errors()->all()]);
        }

        if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])){

            config(['auth.guards.api.provider' => 'admin']);

            $token = Auth::guard('admin')->user()->createToken('Favelax',['admin'])->accessToken;

            return response()->json(['token' => $token], 200);

        }else{

            return response()->json(['error' => ['Email and Password are Wrong.']], 200);
        }
    }

    public function adminDashboard()
    {
        return 'oi';
        return response()->json(Auth::guard('user')->user());
    }
}
