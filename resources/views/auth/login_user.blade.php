<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Razen X UTY')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>
    <main>
        <!-- Main content -->
        <div class="pt-20">  <!-- Adding padding top to prevent overlap with fixed navbar -->
            <div class="max-w-md mx-auto mt-10">
                <h1 class="text-2xl font-bold mb-6">Login</h1>
            
                <form action="{{ route('auth.user.login.submit') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                    @csrf
            
                    {{-- Email --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
                        <input type="email" name="email" id="email"
                            value="{{ old('email') }}"
                            class="shadow appearance-none border {{ $errors->has('email') ? 'border-red-500' : '' }} rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('email')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
            
                    {{-- Password --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
                        <input type="password" name="password" id="password"
                            class="shadow appearance-none border {{ $errors->has('password') ? 'border-red-500' : '' }} rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('password')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
            
                    {{-- Remember & Forgot --}}
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input type="checkbox" name="remember" id="remember" class="mr-2"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember" class="text-sm text-gray-600">Ingat Saya</label>
                        </div>
                        <a href="{{ route('auth.forgot-password') }}" class="text-sm text-blue-500 hover:text-blue-800">Lupa Password?</a>
                    </div>
            
                    {{-- Button --}}
                    <div class="flex items-center justify-between mt-4">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Masuk
                        </button>
                    </div>
                </form>
            
                <p class="mt-4 text-center">Belum punya akun? <a href="{{ route('auth.register') }}"
                        class="text-blue-500 hover:text-blue-800">Daftar di sini</a></p>
            </div>
            
            {{-- SweetAlert --}}
            @if(session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: '{{ session('success') }}',
                        confirmButtonText: 'OK'
                    });
                </script>
            @endif
            
            @if(session('error'))
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: '{{ session('error') }}',
                        confirmButtonText: 'OK'
                    });
                </script>
            @endif
        </div>
    </main>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
