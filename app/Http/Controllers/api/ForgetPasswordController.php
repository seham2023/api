<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\VerifyCodeRequest;
use App\Http\Requests\SendResetCodeRequest;

class ForgetPasswordController extends Controller
{
    public function sendResetCode(SendResetCodeRequest $request)
    {
        $user = User::query()->where($request['type'], $request['username'])->first();

        $reset_code = $this->generateResetCode();

        DB::table('password_resets')
            ->updateOrInsert(
                ['email' => $user->email, 'mobile' => $user->mobile],
                ['code' => $reset_code, 'created_at' => now()]
            );

     
        return $this->respondMessage(trans('message.auth.forget_password.send_code'));

    }


    function generateResetCode()
    {
        return mt_rand(0, 8) . mt_rand(1, 9) . mt_rand(10, 90);
    }

    public function verifyResetCode(VerifyCodeRequest $request){


        return $this->respondMessage(trans('message.auth.forget_password.valid_code'));

    }
}
