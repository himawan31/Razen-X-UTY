@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md p-8 space-y-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center text-gray-800">Forgot Password</h2>
        <p class="text-sm text-center text-gray-600">Enter your email address to reset your password.</p>
        <form action="{{ route('auth.forgot-password.submit') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                <input type="email" name="email" id="email" required
                    class="block w-full px-4 py-2 mt-1 text-gray-700 bg-gray-100 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <button type="submit"
                    class="w-full px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Send Password Reset Link
                </button>
            </div>
        </form>
        <a href="{{ route('login') }}">Kembali</a>
        @if (session('status'))
            <div class="p-4 text-sm text-green-700 bg-green-100 rounded-md">
                {{ session('status') }}
            </div>
        @endif
    </div>
</div>
<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            confirmButtonText: 'OK'
        });
    @endif
</script>
<script>
    @if(session('error'))
        Swal.fire({
            icon: 'failed',
            title: 'Gagal!',
            text: '{{ session('failed') }}',
            confirmButtonText: 'OK'
        });
    @endif
</script>
@endsection