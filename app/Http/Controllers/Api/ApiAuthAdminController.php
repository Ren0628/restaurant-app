<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Auth\AuthenticationException;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class ApiAuthAdminController extends Controller
{
    public function __construct(
        private readonly AuthManager $auth,
    ) {
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required|max:191',
            'email'=>'required|email|max:191|unique:admins,email',
            'password'=>'required|min:8',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->messages(),
            ]);
        } else {
            Admin::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
            ]);

            $credentials = $request->only(['email', 'password']);

            if ($this->auth->guard('admin')->attempt($credentials)) {
                $request->session()->regenerate();
    
                return new JsonResponse([
                    'message' => 'Authenticated.',
                    'auth' => Auth::guard('admin')->user() ,
                    'guard' => 'admin',
                    'status' => 200,
                ]);
            }
        }

        throw new AuthenticationException;
    }

    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email'=>'required|email|max:191',
            'password'=>'required|min:8',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->messages(),
            ]);
        }

        $credentials = $request->only(['email', 'password']);

        if ($this->auth->guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();

            return new JsonResponse([
                'message' => 'Authenticated.',
                'auth' => Auth::guard('admin')->user() ,
                'guard' => 'admin',
                'status' => 200,
            ]);
        } else {
            return new JsonResponse([
                'message' => 'ログイン情報が正しくありません。',
            ]);
        }

        throw new AuthenticationException();
    }

    public function logout(Request $request): JsonResponse
    {
        if ($this->auth->guard('admin')->guest()) {
            return new JsonResponse([
                'message' => 'Already Unauthenticated.',
                'auth' => '',
            ]);
        }

        $this->auth->guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return new JsonResponse([
            'message' => 'Unauthenticated.',
            'auth' => '',
        ]);
    }
}