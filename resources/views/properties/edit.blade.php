@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-6">Ubah Data Properti</h1>

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

    <form action="{{ route('properties.update.submit', $property->id) }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="title">Judul</label>
            <input type="text" name="title" id="title" value="{{ $property->title }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="description">Deskripsi</label>
            <textarea name="description" id="description" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>{{ $property->description }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="price">Harga</label>
            <input type="number" name="price" id="price" value="{{ $property->price }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="location">Lokasi</label>
            <input type="text" name="location" id="location" value="{{ $property->location }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <p class="text-gray-700 font-semibold">Gambar Saat Ini:</p>

        @if($property->images_url->isNotEmpty())
            <img src="{{ Storage::url($property->images_url->first()->image_url) }}" alt="Foto Properti" style="max-width: 730px; height: 200px;">
        @else
            N/A
        @endif

        <br>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="image">Upload Gambar Baru</label>
            <input type="file" name="image" id="image" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        {{-- Dokumen saat ini (jika ada) --}}
        @if($property->documents->isNotEmpty())
            <div class="mb-4">
                <p class="text-gray-700 font-semibold">Dokumen Saat Ini:</p>
                <ul class="list-disc ml-6">
                    @foreach($property->documents as $document)
                        <li>
                            <a href="{{ Storage::url($document->document_url) }}" target="_blank" class="text-blue-600 underline">
                                {{ $document->document_type }} (Lihat Dokumen)
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="document">Upload Dokumen Baru (PDF)</label>
            <input type="file" name="document" id="document" accept="application/pdf" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <p class="text-sm text-gray-500 mt-1">Maksimal 5MB. File sebelumnya akan diganti.</p>
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Ubah Properti
            </button>
        </div>
    </form>

    <a href="{{ route('dashboard') }}" class="text-blue-500 hover:underline">Kembali</a>
</div>
@endsection
