@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10 px-6">
    <h1 class="text-3xl font-extrabold text-gray-900 mb-6">Ubah Data Properti</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Ada yang salah!</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('properties.update.submit', $property->id) }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-xl rounded-lg px-8 pt-6 pb-8 mb-4 space-y-6">
        @csrf
        @method('PUT')

        <!-- Title Field -->
        <div class="mb-4">
            <label class="block text-gray-700 text-lg font-semibold mb-2" for="title">Judul Properti</label>
            <input type="text" name="title" id="title" value="{{ $property->title }}" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>

        <!-- Description Field -->
        <div class="mb-4">
            <label class="block text-gray-700 text-lg font-semibold mb-2" for="description">Deskripsi Properti</label>
            <textarea name="description" id="description" rows="4" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ $property->description }}</textarea>
        </div>

        <!-- Price Field -->
        <div class="mb-4">
            <label class="block text-gray-700 text-lg font-semibold mb-2" for="price">Harga Properti</label>
            <input type="number" name="price" id="price" value="{{ $property->price }}" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>

        <!-- Location Field -->
        <div class="mb-4">
            <label class="block text-gray-700 text-lg font-semibold mb-2" for="location">Lokasi Properti</label>
            <input type="text" name="location" id="location" value="{{ $property->location }}" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>

        <!-- Current Image Section -->
        <div>
            <p class="text-gray-700 font-semibold">Gambar Saat Ini:</p>
            @if($property->images_url->isNotEmpty())
                <img src="{{ Storage::url($property->images_url->first()->image_url) }}" alt="Foto Properti" class="w-full h-48 object-cover rounded-lg shadow-lg mt-4">
            @else
                <p class="text-gray-600 mt-2">Tidak ada gambar yang diunggah.</p>
            @endif
        </div>

        <!-- Image Upload Field -->
        <div class="mb-4">
            <label class="block text-gray-700 text-lg font-semibold mb-2" for="image">Upload Gambar Baru</label>
            <input type="file" name="image" id="image" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Current Documents Section -->
        @if($property->documents->isNotEmpty())
            <div>
                <p class="text-gray-700 font-semibold">Dokumen Saat Ini:</p>
                <ul class="list-disc pl-6 text-gray-700 space-y-2">
                    @foreach($property->documents as $document)
                        <li>
                            <a href="{{ Storage::url($document->document_url) }}" target="_blank" class="text-blue-600 underline hover:text-blue-800">
                                {{ $document->document_type }} (Lihat Dokumen)
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Document Upload Field -->
        <div class="mb-4">
            <label class="block text-gray-700 text-lg font-semibold mb-2" for="document">Upload Dokumen Baru (PDF)</label>
            <input type="file" name="document" id="document" accept="application/pdf" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500">
            <p class="text-sm text-gray-500 mt-2">Maksimal 5MB. File sebelumnya akan diganti.</p>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-between">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out">
                Ubah Properti
            </button>
        </div>
    </form>

    <!-- Back Button -->
    <div class="mt-6">
        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">Kembali ke Daftar Properti</a>
    </div>
</div>
@endsection
