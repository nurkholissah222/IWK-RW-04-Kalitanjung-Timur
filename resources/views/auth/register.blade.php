<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf
        
        @if(isset($dbError))
            <div class="p-4 mb-4 rounded-2xl bg-red-500/10 border border-red-500/50 text-red-400 text-sm flex items-center space-x-3">
                <i class="fas fa-exclamation-triangle"></i>
                <span>{{ $dbError }}</span>
            </div>
        @endif

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-slate-400 font-bold uppercase tracking-widest text-[10px] mb-2 ml-1" />
            <div class="relative group">
                <x-text-input id="name" class="block w-full bg-input-guest border-slate-200 text-input-guest placeholder-slate-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 rounded-2xl py-3.5 px-5 transition-all duration-300 outline-none" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nama Lengkap" />
                <div class="absolute inset-0 rounded-2xl bg-indigo-500/5 opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity"></div>
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-slate-400 font-bold uppercase tracking-widest text-[10px] mb-2 ml-1" />
            <div class="relative group">
                <x-text-input id="email" class="block w-full bg-input-guest border-slate-200 text-input-guest placeholder-slate-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 rounded-2xl py-3.5 px-5 transition-all duration-300 outline-none" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="name@example.com" />
                <div class="absolute inset-0 rounded-2xl bg-indigo-500/5 opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity"></div>
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Unit RT Selection -->
        <div>
            <x-input-label for="rt_id" value="Unit RT" class="text-slate-400 font-bold uppercase tracking-widest text-[10px] mb-2 ml-1" />
            <div class="relative group">
                <select id="rt_id" name="rt_id" required class="block w-full bg-input-guest border-slate-200 text-input-guest focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 rounded-2xl py-3.5 px-5 transition-all duration-300 appearance-none outline-none cursor-pointer">
                    <option value="" class="text-slate-400">-- Pilih Unit RT --</option>
                    @foreach($rtUnits as $rt)
                        <option value="{{ $rt->id }}" class="font-semibold">RT {{ $rt->nomor_rt }} (Ketua: {{ $rt->nama_ketua }})</option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-5 pointer-events-none text-slate-400 group-hover:text-indigo-400 transition-colors">
                    <i class="fas fa-chevron-down text-xs"></i>
                </div>
                <div class="absolute inset-0 rounded-2xl bg-indigo-500/5 opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity"></div>
            </div>
            <x-input-error :messages="$errors->get('rt_id')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-slate-400 font-bold uppercase tracking-widest text-[10px] mb-2 ml-1" />
            <div class="relative group">
                <x-text-input id="password" class="block w-full bg-input-guest border-slate-200 text-input-guest placeholder-slate-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 rounded-2xl py-3.5 px-5 transition-all duration-300 outline-none"
                                type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
                
                <button type="button" onclick="togglePassword(this)" class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-indigo-500 transition-all duration-300 focus:outline-none">
                    <i class="fas fa-eye"></i>
                </button>

                <div class="absolute inset-0 rounded-2xl bg-indigo-500/5 opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity"></div>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-slate-400 font-bold uppercase tracking-widest text-[10px] mb-2 ml-1" />
            <div class="relative group">
                <x-text-input id="password_confirmation" class="block w-full bg-input-guest border-slate-200 text-input-guest placeholder-slate-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 rounded-2xl py-3.5 px-5 transition-all duration-300 outline-none"
                                type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                
                <button type="button" onclick="togglePassword(this)" class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-indigo-500 transition-all duration-300 focus:outline-none">
                    <i class="fas fa-eye"></i>
                </button>

                <div class="absolute inset-0 rounded-2xl bg-indigo-500/5 opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity"></div>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="text-sm text-slate-500 hover:text-indigo-400 font-medium transition-colors" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <button type="submit" class="px-8 py-3.5 bg-indigo-600 hover:bg-indigo-500 text-white font-black uppercase tracking-widest text-xs rounded-2xl shadow-[0_10px_20px_rgba(79,70,229,0.3)] hover:shadow-[0_15px_25px_rgba(79,70,229,0.4)] transition-all duration-300 transform hover:-translate-y-1 active:scale-[0.98]">
                REGISTER AKUN
            </button>
        </div>
    </form>
</x-guest-layout>
