<?php

namespace App\Http\Controllers;

use App\Actions\Auth\ResetPasswordAction;
use App\Actions\Auth\SendPasswordResetLinkAction;
use App\DTOs\ResetPasswordData;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PasswordResetController extends Controller
{
    public function __construct(
        private SendPasswordResetLinkAction $sendPasswordResetLink,
        private ResetPasswordAction $resetPassword,
    ) {}

    public function showForgotPassword(): View
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $this->sendPasswordResetLink->handle($validated['email']);

        return back()->with('status', __('ui.passwords.sent'));
    }

    public function showResetPassword(Request $request, string $token): View
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    public function reset(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'token' => ['required', 'string'],
        ]);

        $reset = $this->resetPassword->handle(new ResetPasswordData(
            email: $validated['email'],
            password: $validated['password'],
            token: $validated['token'],
        ));

        if (! $reset) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => __('ui.passwords.invalid_token')]);
        }

        return redirect()->route('login')->with('status', __('ui.passwords.reset_done'));
    }
}
