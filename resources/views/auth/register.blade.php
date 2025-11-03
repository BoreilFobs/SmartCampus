<x-guest-layout>
    <!-- Page Title -->
    <div class="text-center mb-4">
        <h1 class="h3 fw-bold text-dark">Create Account</h1>
        <p class="text-muted">Join SmartCampus today</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="needs-validation">
        @csrf

        <!-- Name -->
        <div class="mb-3">
            <x-input-label for="name" :value="__('Full Name')" />
            <x-text-input id="name" 
                          type="text" 
                          name="name" 
                          :value="old('name')" 
                          required 
                          autofocus 
                          autocomplete="name"
                          placeholder="John Doe"
                          class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" />
            <x-input-error :messages="$errors->get('name')" class="invalid-feedback d-block" />
        </div>

        <!-- Email Address -->
        <div class="mb-3">
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input id="email" 
                          type="email" 
                          name="email" 
                          :value="old('email')" 
                          required 
                          autocomplete="username"
                          placeholder="you@example.com"
                          class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" />
            <x-input-error :messages="$errors->get('email')" class="invalid-feedback d-block" />
        </div>

        <!-- Password -->
        <div class="mb-3">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password"
                          type="password"
                          name="password"
                          required 
                          autocomplete="new-password"
                          placeholder="Create a strong password"
                          class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" />
            <x-input-error :messages="$errors->get('password')" class="invalid-feedback d-block" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation"
                          type="password"
                          name="password_confirmation"
                          required 
                          autocomplete="new-password"
                          placeholder="Confirm your password"
                          class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="invalid-feedback d-block" />
        </div>

        <!-- Register Button -->
        <button type="submit" class="btn btn-primary w-100 fw-semibold py-2 mb-3">
            {{ __('Create Account') }}
        </button>

        <!-- Login Link -->
        <div class="text-center">
            <p class="text-muted small mb-0">
                {{ __('Already have an account?') }}
                <a class="text-decoration-none text-primary fw-semibold" href="{{ route('login') }}">
                    {{ __('Sign in here') }}
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
