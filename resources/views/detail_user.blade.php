@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-500 mb-4">
        <a href="{{ route('home') }}" class="hover:underline">Beranda</a> /
        <span class="text-gray-700 font-medium">{{ $property->title }}</span>
    </nav>

    <!-- Title & Favorite -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-2 md:mb-0">{{ $property->title }}</h1>
        @auth
            <form
                action="{{ in_array($property->id, $favorites) ? route('favorites.remove', $property->id) : route('favorites.add', $property->id) }}"
                method="POST">
                @csrf
                @if (in_array($property->id, $favorites))
                    @method('DELETE')
                @endif
                <button type="submit"
                    class="px-5 py-2 rounded-md font-medium transition 
                    {{ in_array($property->id, $favorites) ? 'bg-red-500 text-white hover:bg-red-600' : 'bg-gray-200 text-gray-800 hover:bg-gray-300' }}">
                    {{ in_array($property->id, $favorites) ? 'Hapus dari Favorit' : 'Tambah ke Favorit' }}
                </button>
            </form>
        @endauth
    </div>

    <!-- Image Gallery -->
    @if ($property->images_url->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            @foreach ($property->images_url as $image)
                <div class="rounded-lg overflow-hidden shadow-md">
                    <img src="{{ Storage::url($image->image_url) }}"
                        class="w-full h-64 object-cover transition-transform duration-300 hover:scale-105"
                        alt="{{ $property->title }}">
                </div>
            @endforeach
        </div>
    @endif

    <!-- Info Utama -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-gray-700"><span class="font-semibold">Lokasi:</span> {{ $property->location }}</p>
                <p class="text-gray-700 mt-3">
                    <span class="font-semibold">Harga:</span>
                    <span class="inline-block bg-green-100 text-green-800 text-sm font-semibold px-3 py-1 rounded-full">
                        Rp {{ number_format($property->price, 0, ',', '.') }}
                    </span>
                </p>
            </div>
        </div>
    </div>

    <!-- Deskripsi -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-3">Deskripsi</h2>
        <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $property->description }}</p>
    </div>

    <!-- Tombol Aksi -->
    <div class="flex flex-col md:flex-row items-center justify-center gap-4">
        <a href="#"
           class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg shadow transition duration-200 w-full md:w-auto text-center">
            Beli Properti
        </a>
        <a href="#"
           class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-6 py-3 rounded-lg shadow transition duration-200 w-full md:w-auto text-center">
            Sewa Properti
        </a>
    </div>
</div>
@endsection
