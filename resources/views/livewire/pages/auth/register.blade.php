<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('home', absolute: false), navigate: true);
    }
}; ?>

<div class="animate-fade-in">
    <div class="mb-8">
        <h1 class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-slate-100">Create an account</h1>
        <p class="text-sm text-slate-500 mt-2">Let's set up your business profile to get started.</p>
    </div>

    <form wire:submit="register" class="space-y-5">
        <!-- Name -->
        <div>
            <label for="name" class="form-label">{{ __('Full Name') }}</label>
            <input wire:model="name" id="name" class="form-input-styled" type="text" name="name" required autofocus autocomplete="name" placeholder="John Doe" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="form-label">{{ __('Email address') }}</label>
            <input wire:model="email" id="email" class="form-input-styled" type="email" name="email" required autocomplete="username" placeholder="you@company.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="form-label">{{ __('Password') }}</label>
            <input wire:model="password" id="password" class="form-input-styled" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
            <input wire:model="password_confirmation" id="password_confirmation" class="form-input-styled" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-2">
            <button type="submit" class="btn-primary w-full">
                {{ __('Create Account') }}
            </button>
        </div>
        
        <p class="text-center text-sm text-slate-500 mt-6">
            Already have an account? 
            <a href="{{ route('login') }}" wire:navigate class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors">Sign in</a>
        </p>
    </form>
</div>
