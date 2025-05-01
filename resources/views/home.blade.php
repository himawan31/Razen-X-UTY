@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-4xl font-extrabold text-center text-gray-800 mb-12 tracking-tight">
            Temukan Properti Impian Anda
        </h1>

        @if ($properties->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach ($properties as $property)
                    <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-shadow duration-300 overflow-hidden flex flex-col border border-gray-100 group">

                        @if ($property->images_url->isNotEmpty())
                            <div class="overflow-hidden">
                                <img src="{{ Storage::url($property->images_url->first()->image_url) }}"
                                    alt="{{ $property->title }}"
                                    class="w-full h-56 object-cover transform group-hover:scale-105 transition-transform duration-300">
                            </div>
                        @endif

                        <div class="p-6 flex flex-col flex-grow space-y-3">
                            <h2 class="text-2xl font-bold text-gray-800 leading-snug group-hover:text-blue-600 transition">
                                {{ $property->title }}
                            </h2>

                            <p class="text-sm text-gray-500 flex items-center">
                                <i class="fa-solid fa-location-dot mr-1 text-red-500"></i>
                                {{ $property->location }}
                            </p>

                            <p class="text-xl text-green-600 font-semibold">
                                Rp {{ number_format($property->price, 0, ',', '.') }}
                            </p>

                            <p class="text-sm text-gray-700">
                                {{ Str::limit($property->description, 100) }}
                            </p>

                            <div class="mt-auto flex justify-between items-center pt-4 border-t border-gray-100">
                                <a href="{{ route('details', $property->id) }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-2 px-4 rounded-full transition duration-200">
                                    Lihat Detail
                                </a>

                                <form method="POST"
                                    action="{{ in_array($property->id, $favorites) ? route('favorites.remove', $property->id) : route('favorites.add', $property->id) }}">
                                    @csrf
                                    @if (in_array($property->id, $favorites ?? []))
                                        @method('DELETE')
                                        <button type="submit" title="Hapus dari Favorit"
                                            class="text-red-500 hover:text-red-600 transition p-2 rounded-full bg-red-100 hover:bg-red-200">
                                            <!-- Heart Solid -->
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                viewBox="0 0 24 24" class="w-5 h-5">
                                                <path fill-rule="evenodd"
                                                    d="M11.999 4.529c2.349-2.314 6.174-2.354 8.54-.093 2.408 2.297 2.44 6.113.095 8.466l-7.65 7.606a1 1 0 01-1.41 0l-7.65-7.606c-2.346-2.353-2.313-6.17.095-8.466 2.366-2.261 6.191-2.22 8.54.093z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    @else
                                        <button type="submit" title="Tambahkan ke Favorit"
                                            class="text-gray-400 hover:text-red-500 transition p-2 rounded-full bg-gray-100 hover:bg-red-100">
                                            <!-- Heart Outline -->
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11.999 5.5c1.711-1.687 4.5-1.717 6.23-.068 1.756 1.676 1.774 4.462.07 6.185L12 19.25l-6.298-7.633c-1.703-1.723-1.686-4.51.07-6.185 1.73-1.649 4.519-1.619 6.23.068z" />
                                            </svg>
                                        </button>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-gray-500 text-lg mt-16">
                Belum ada properti yang tersedia saat ini.
            </p>
        @endif
    </div>
@endsection
