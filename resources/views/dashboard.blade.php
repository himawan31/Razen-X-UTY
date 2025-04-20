<!-- File: /d:/project_razen_x_uty/resources/views/dashboard.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Daftar Properti</h1>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-600 uppercase">#</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-600 uppercase">Nama Properti</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-600 uppercase">Lokasi</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-600 uppercase">Harga</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-600 uppercase">Gambar</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-600 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($properties as $property)
                <tr>
                    <td class="px-6 py-4 border-b border-gray-200 text-sm">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 border-b border-gray-200 text-sm">{{ $property->title }}</td>
                    <td class="px-6 py-4 border-b border-gray-200 text-sm">{{ $property->location }}</td>
                    <td class="px-6 py-4 border-b border-gray-200 text-sm">{{ number_format($property->price, 0, ',', '.') }}</td>
                    <td>
                        @if($property->imagePath)
                            <img src="{{ Storage::url($property->imagePath) }}" alt="Foto Objek Wisata" style="max-width: 100%; height: auto;">
                        @else
                            N/A
                        @endif
                    </td>
                    <td class="px-6 py-4 border-b border-gray-200 text-sm">
                        <a href="{{ route('properties.show', $property->id) }}" class="text-blue-500 hover:underline">Detail</a>
                        <a href="{{ route('properties.edit', $property->id) }}" class="text-yellow-500 hover:underline ml-2">Edit</a>
                        <form action="{{ route('properties.destroy', $property->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline ml-2" onclick="return confirm('Apakah Anda yakin ingin menghapus properti ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
        <a class="px-10 py-16" href="{{ route('properties.create') }}">Tambah Data</a>
</div>
@endsection