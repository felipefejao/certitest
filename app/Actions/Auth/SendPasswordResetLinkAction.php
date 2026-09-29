<?php

namespace App\Actions\Auth;

use Illuminate\Support\Facades\Password;

class SendPasswordResetLinkAction
{
    public function handle(string $email): void
    {
        Password::broker()->sendResetLink(['email' => $email]);
    }
}
