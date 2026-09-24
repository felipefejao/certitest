<?php

namespace App\Http\Controllers;

use App\Models\ExamThemeSuggestion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ThemeSuggestionController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'theme' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'captcha' => ['required', 'integer'],
            'website' => ['prohibited'],
        ], [
            'theme.required' => 'Informe o tema da prova.',
            'email.required' => 'Informe seu e-mail.',
            'email.email' => 'Informe um e-mail válido.',
            'captcha.required' => 'Responda à verificação.',
            'website.prohibited' => 'Não foi possível enviar sua sugestão.',
        ]);

        $expected = $request->session()->pull('suggestion_captcha_answer');

        if ($expected === null || (int) $validated['captcha'] !== (int) $expected) {
            throw ValidationException::withMessages([
                'captcha' => 'Resposta incorreta. Tente novamente.',
            ]);
        }

        ExamThemeSuggestion::create([
            'theme' => $validated['theme'],
            'email' => $validated['email'],
        ]);

        return redirect()
            ->route('home')
            ->with('suggestion_success', 'Obrigado! Sua sugestão foi enviada.');
    }
}
