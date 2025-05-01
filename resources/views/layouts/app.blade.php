<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Razen x UTY')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>
    <main>
        <!-- Navbar -->
        <nav class="bg-gray-900 p-4 shadow-md flex justify-between items-center fixed top-0 left-0 w-full z-50">
            <div class="text-white text-xl font-bold hover:text-green-400 transition duration-300">
                Sistem Razen x UTY
            </div>
            
            <div class="flex items-center space-x-6">
                @if(Auth::check() && Auth::user()->role === 'user')
                    <a href="{{ route('home') }}" 
                       class="text-white hover:text-green-400 font-medium transition duration-300">
                        <i class="fa-solid fa-heart mr-1 text-red-500"></i> Beranda
                    </a>
                    <a href="{{ route('favorites') }}" 
                       class="text-white hover:text-green-400 font-medium transition duration-300">
                        <i class="fa-solid fa-heart mr-1 text-red-500"></i> Favorit
                    </a>
                @endif
        
                <form action="{{ route('auth.logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-white bg-red-600 hover:bg-red-700 px-6 py-2 rounded-full transition duration-300">
                        Logout
                    </button>
                </form>
            </div>
        </nav>
        
        
        <!-- Main content -->
        <div class="pt-20">  <!-- Adding padding top to prevent overlap with fixed navbar -->
            @yield('content')
        </div>
    </main>

    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
