@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <!-- Property Detail Card -->
    <div class="bg-white rounded-xl shadow-2xl p-8 space-y-8 max-w-7xl mx-auto">
        <!-- Property Title and Info -->
        <div class="space-y-4">
            <h1 class="text-5xl font-extrabold text-gray-900">{{ $property->title }}</h1>
            <p class="text-lg text-gray-600"><strong>Lokasi:</strong> {{ $property->location }}</p>
            <p class="text-4xl font-bold text-green-700">Rp {{ number_format($property->price, 0, ',', '.') }}</p>
        </div>

        <!-- Description Section -->
        <div class="property-description">
            <h3 class="text-3xl font-semibold text-gray-800">Deskripsi</h3>
            <p class="text-gray-700 mt-4">{{ $property->description }}</p>
        </div>

        <!-- Images Section -->
        <div class="property-images">
            <h3 class="text-3xl font-semibold text-gray-800">Gambar Properti</h3>
            @if($property->images && count($property->images) > 0)
                <div class="image-gallery grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mt-6">
                    @foreach($property->images as $image)
                        <div class="image-item overflow-hidden rounded-lg shadow-lg">
                            <img src="{{ Storage::url($image->image_url) }}" alt="Gambar Properti" class="w-full h-64 object-cover">
                        </div>
                    @endforeach
                </div>
            @else
                <p class="mt-4 text-gray-600">Tidak ada gambar tersedia.</p>
            @endif
        </div>

        <!-- Documents Section -->
        <div class="property-documents">
            <h3 class="text-3xl font-semibold text-gray-800">Dokumen</h3>
            @if($property->documents && count($property->documents) > 0)
                <ul class="list-disc list-inside mt-6 text-gray-700 space-y-2">
                    @foreach($property->documents as $document)
                        <li>
                            <a href="{{ Storage::url($document->document_url) }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-lg transition duration-300">Lihat Dokumen</a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="mt-4 text-gray-600">Tidak ada dokumen tersedia.</p>
            @endif
        </div>

        <!-- Back Button -->
        <div class="mt-8">
            <a href="{{ route('dashboard') }}" class="inline-block px-6 py-3 bg-blue-600 text-white text-lg font-semibold rounded-full shadow-xl hover:bg-blue-700 transition duration-300 hover:shadow-2xl">Kembali ke Daftar Properti</a>
        </div>
    </div>
</div>
@endsection
