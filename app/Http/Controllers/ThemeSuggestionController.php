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
            'theme.required' => __('ui.suggestion.theme_required'),
            'email.required' => __('ui.suggestion.email_required'),
            'email.email' => __('ui.suggestion.email_invalid'),
            'captcha.required' => __('ui.suggestion.captcha_required'),
            'website.prohibited' => __('ui.suggestion.website_prohibited'),
        ]);

        $expected = $request->session()->pull('suggestion_captcha_answer');

        if ($expected === null || (int) $validated['captcha'] !== (int) $expected) {
            throw ValidationException::withMessages([
                'captcha' => __('ui.suggestion.captcha_wrong'),
            ]);
        }

        ExamThemeSuggestion::create([
            'theme' => $validated['theme'],
            'email' => $validated['email'],
        ]);

        return redirect()
            ->route('home')
            ->with('suggestion_success', __('ui.suggestion.success'));
    }
}
