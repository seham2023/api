<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\ResetPasswordRequest;

class ResetPasswordController extends Controller
{
    public function setNewPassword(ResetPasswordRequest $request)
    {
        $user = User::query()->where($request['type'], $request['username'])->first();

        if (!$user) {
            return $this->respondError(trans('message.auth.user.not_found'));
        }

        $user->update(['password' => $request['password']]);

        DB::table('password_resets')->where('email', $user->email)->delete();

        return $this->respondData([
            'user' => new UserResource($user),
            'token' => $user->createToken(env('APP_NAME', 'Passport Token'))->accessToken
        ], Response::HTTP_OK, trans('message.auth.user.password_reset'));
    }
}
