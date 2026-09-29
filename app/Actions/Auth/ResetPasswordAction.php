<?php

namespace App\Actions\Auth;

use App\DTOs\ResetPasswordData;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordAction
{
    public function handle(ResetPasswordData $data): bool
    {
        $status = Password::broker()->reset(
            [
                'email' => $data->email,
                'password' => $data->password,
                'password_confirmation' => $data->password,
                'token' => $data->token,
            ],
            function ($user) use ($data) {
                $user->forceFill([
                    'password' => $data->password,
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET;
    }
}
