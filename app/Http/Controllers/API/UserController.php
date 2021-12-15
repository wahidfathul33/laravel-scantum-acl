<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Traits\ApiResponser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Validator;

class UserController extends Controller
{
    use ApiResponser;

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'  => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        if($validator->fails()){
            return $this->error('The given data was invalid.', 400, $validator->errors()); 
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
         ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->success(
            [
                'user' => $user, 
                'access_token' => $token,
                'token_type' => 'Bearer'
            ], 'User created.', 201
        );
    }

    public function profile()
    {
        return $this->success([
            'user' => auth()->user()
        ], 'Successfully retrieve data.');
    }
}
