@extends('layouts.app')

@section('title', 'Daftar Favorit')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    <nav class="text-sm text-gray-500 mb-4">
        <a href="{{ route('home') }}" class="hover:underline">Beranda</a> /
        <span class="text-gray-700 font-medium">Favorit</span>
    </nav>
    <h1 class="text-3xl font-bold text-gray-800 text-center mb-10">Daftar Properti Favorit Anda</h1>

    @if ($favorites->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($favorites as $property)
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition duration-300 overflow-hidden flex flex-col">
                    @if ($property->images_url->isNotEmpty())
                        <img src="{{ Storage::url($property->images_url->first()->image_url) }}"
                             alt="{{ $property->title }}" class="w-full h-56 object-cover">
                    @else
                        <div class="w-full h-56 bg-gray-200 flex items-center justify-center text-gray-500">
                            Tidak ada gambar
                        </div>
                    @endif

                    <div class="p-5 flex flex-col flex-grow">
                        <h2 class="text-xl font-semibold text-gray-800 mb-1">{{ $property->title }}</h2>
                        <p class="text-sm text-gray-500 flex items-center mb-2">
                            <i class="fa-solid fa-location-dot mr-1 text-red-500"></i> {{ $property->location }}
                        </p>
                        <p class="text-lg text-green-600 font-bold mb-3">Rp {{ number_format($property->price, 0, ',', '.') }}</p>
                        <p class="text-sm text-gray-700 mb-4">{{ Str::limit($property->description, 100) }}</p>

                        <div class="mt-auto flex justify-between items-center">
                            <a href="{{ route('properties.show', $property->id) }}"
                               class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-md transition duration-200">
                                Lihat Detail
                            </a>

                            <form method="POST" action="{{ route('favorites.remove', $property->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Hapus dari Favorit"
                                        class="text-red-500 hover:text-red-600 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                         viewBox="0 0 24 24" class="w-6 h-6">
                                        <path fill-rule="evenodd"
                                              d="M11.999 4.529c2.349-2.314 6.174-2.354 8.54-.093 2.408 2.297 2.44 6.113.095 8.466l-7.65 7.606a1 1 0 01-1.41 0l-7.65-7.606c-2.346-2.353-2.313-6.17.095-8.466 2.366-2.261 6.191-2.22 8.54.093z"
                                              clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center mt-16">
            <h2 class="text-gray-600 text-lg">Belum ada properti favorit yang disimpan.</h2>
            <a href="{{ route('home') }}"
               class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-full transition duration-300">
                Jelajahi Properti
            </a>
        </div>
    @endif
</div>
@endsection
