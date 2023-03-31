<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {

        $validated = $request->validated();
        $validated['password'] = Hash::make($request->password);

        $user =    User::create($validated);
        $success['token'] = $user->createtoken('auth_token')->plainTextToken;
        $success['name'] =  $user->name;
        return $this->makeResponse(201, 'created', $success);
    }



    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {

            $user = auth()->user();
            $success['token'] = $user->createtoken('auth_token')->plainTextToken;
            $success['name'] =  $user->name;
            return $this->makeResponse(200, 'ok', $success);
        }

        return $this->makeResponse(400, 'credential didnt match');
    }
}
