<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {

        $validated = $request->validated();

        $user =    User::create($validated);
        $success['token'] = $user->createtoken('auth_token')->plainTextToken;
        $success['user'] =  new UserResource($user);
        $success['successs'] =  true;
        return $this->respondData([
            'user' => new UserResource($user),
            'token' => $user->createToken(env('APP_NAME', 'Passport Token'))->accessToken
        ]);    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt([$request->username_type => $request['username'], 'password' => $request['password']], true))
        {

            $user = auth()->user();
            $success['token'] = $user->createtoken('auth_token')->plainTextToken;
            $success['user'] =  new UserResource($user);
            $success['successs'] =  true;
            return $this->respondData([
                'user' => new UserResource($user),
                'token' => $user->createToken(env('APP_NAME', 'Passport Token'))->accessToken
            ]);
            // return $this->makeResponse(200, 'ok', $success);
        }

        throw ValidationException::withMessages(['password' => trans('message.auth.login.wrong_password')]);


        // return $this->makeResponse(400, 'credential didnt match');
    }




    // if (Auth::attempt([$request->username_type => $request['username'], 'password' => $request['password']], true))
    //  {
    //     return redirect()->route('home');
    // }




















}
