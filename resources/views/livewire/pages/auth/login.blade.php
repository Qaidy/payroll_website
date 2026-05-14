<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('home', absolute: false), navigate: true);
    }
}; ?>

<div class="animate-fade-in">
    <div class="mb-8">
        <h1 class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-slate-100">Sign in to your account</h1>
        <p class="text-sm text-slate-500 mt-2">Enter your details to proceed to the payroll dashboard.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login" class="space-y-5">
        <!-- Email Address -->
        <div>
            <label for="email" class="form-label">{{ __('Email address') }}</label>
            <input wire:model="form.email" id="email" class="form-input-styled" type="email" name="email" required autofocus autocomplete="username" placeholder="you@company.com" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center mb-1.5">
                <label for="password" class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ __('Password') }}</label>
                @if (Route::has('password.request'))
                    <a class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 font-medium transition-colors" href="{{ route('password.request') }}" wire:navigate>
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <input wire:model="form.password" id="password" class="form-input-styled" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox" class="rounded border-slate-300 dark:border-slate-600 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:bg-slate-700" name="remember">
                <span class="ms-2 text-sm text-slate-600 dark:text-slate-400">{{ __('Remember me for 30 days') }}</span>
            </label>
        </div>

        <div class="pt-2">
            <button type="submit" class="btn-primary w-full">
                {{ __('Sign In') }}
            </button>
        </div>
        
        <p class="text-center text-sm text-slate-500 mt-6">
            Don't have an account? 
            <a href="{{ route('register') }}" wire:navigate class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors">Sign up</a>
        </p>
    </form>
</div>
