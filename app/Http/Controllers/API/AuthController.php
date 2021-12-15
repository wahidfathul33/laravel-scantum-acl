<?php
namespace App\Http\Controllers\API;

use App\Models\User;
use App\Traits\ApiResponser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Validator;

class AuthController extends Controller
{
    use ApiResponser;

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password')))
        {
            return $this->error('The provided credentials are incorrect.', 400);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->success([
            'user' => $user, 
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    // method for user logout and delete token
    public function logout()
    {
        auth()->user()->tokens()->delete();
        
        return $this->success(
            '', //data
            'You have successfully logged out and the token was successfully deleted'
        );
    }
}