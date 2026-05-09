<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-slate-400 font-bold uppercase tracking-widest text-[10px] mb-2 ml-1" />
            <div class="relative group">
                <x-text-input id="email" class="block w-full bg-input-guest border-white/10 text-input-guest placeholder-slate-500 focus:border-indigo-500 focus:ring-indigo-500/20 rounded-2xl py-4 px-5 transition-all duration-300" 
                    type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="name@example.com" />
                <div class="absolute inset-0 rounded-2xl bg-indigo-500/5 opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity"></div>
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-slate-400 font-bold uppercase tracking-widest text-[10px] mb-2 ml-1" />
            <div class="relative group">
                <x-text-input id="password" class="block w-full bg-input-guest border-white/10 text-input-guest placeholder-slate-500 focus:border-indigo-500 focus:ring-indigo-500/20 rounded-2xl py-4 px-5 transition-all duration-300"
                    type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                
                <button type="button" onclick="togglePassword(this)" class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-indigo-500 transition-all duration-300 focus:outline-none">
                    <i class="fas fa-eye"></i>
                </button>

                <div class="absolute inset-0 rounded-2xl bg-indigo-500/5 opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity"></div>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" class="rounded-md bg-white/5 border-white/10 text-indigo-600 shadow-sm focus:ring-indigo-500/20 transition-all" name="remember">
                <span class="ms-2 text-sm text-slate-400 group-hover:text-slate-200 transition-colors">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-slate-500 hover:text-indigo-400 font-medium transition-colors" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-black uppercase tracking-widest rounded-2xl shadow-[0_10px_20px_rgba(79,70,229,0.3)] hover:shadow-[0_15px_25px_rgba(79,70,229,0.4)] transition-all duration-300 transform hover:-translate-y-1 active:scale-[0.98]">
                {{ __('Log in to System') }}
            </button>
        </div>
    </form>
</x-guest-layout>
