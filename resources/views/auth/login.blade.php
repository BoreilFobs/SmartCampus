<x-guest-layout>
    <!-- Page Title -->
    <div class="text-center mb-4">
        <h1 class="h3 fw-bold text-dark">Welcome Back</h1>
        <p class="text-muted">Sign in to your SmartCampus account</p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="needs-validation">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input id="email" 
                          type="email" 
                          name="email" 
                          :value="old('email')" 
                          required 
                          autofocus 
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
                          autocomplete="current-password"
                          placeholder="Enter your password"
                          class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" />
            <x-input-error :messages="$errors->get('password')" class="invalid-feedback d-block" />
        </div>

        <!-- Remember Me -->
        <div class="mb-3 form-check">
            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
            <label class="form-check-label" for="remember_me">
                {{ __('Remember me') }}
            </label>
        </div>

        <!-- Login Button and Links -->
        <button type="submit" class="btn btn-primary w-100 fw-semibold py-2 mb-3">
            {{ __('Sign In') }}
        </button>

        <!-- Forgot Password and Register Links -->
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            @if (Route::has('password.request'))
                <a class="text-decoration-none text-primary small" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
            @if (Route::has('register'))
                <a class="text-decoration-none text-primary small" href="{{ route('register') }}">
                    {{ __("Don't have an account? Register") }}
                </a>
            @endif
        </div>
    </form>
</x-guest-layout>
