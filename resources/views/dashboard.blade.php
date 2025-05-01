@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6 mt-8">
        <!-- Heading Section -->
        <h1 class="text-4xl font-bold mb-8 text-gray-900 tracking-tight">Daftar Properti</h1>

        <!-- Property Table -->
        <div class="overflow-x-auto bg-white shadow-2xl rounded-lg border border-gray-200">
            <table class="min-w-full table-auto">
                <thead class="bg-gradient-to-r from-blue-600 to-blue-800 text-white">
                    <tr>
                        <th class="px-8 py-4 text-sm font-medium">#</th>
                        <th class="px-8 py-4 text-sm font-medium">Nama Properti</th>
                        <th class="px-8 py-4 text-sm font-medium">Lokasi</th>
                        <th class="px-8 py-4 text-sm font-medium">Harga</th>
                        <th class="px-8 py-4 text-sm font-medium">Deskripsi</th>
                        <th class="px-8 py-4 text-sm font-medium">Gambar</th>
                        <th class="px-8 py-4 text-sm font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600">
                    @foreach ($properties as $property)
                        <tr class="hover:bg-gray-50 transition duration-300">
                            <td class="px-8 py-6 text-sm font-medium">{{ $loop->iteration }}</td>
                            <td class="px-8 py-6 text-sm font-medium">{{ $property->title }}</td>
                            <td class="px-8 py-6 text-sm font-medium">{{ $property->location }}</td>
                            <td class="px-8 py-6 text-sm font-medium whitespace-nowrap min-w-[150px]">Rp {{ number_format($property->price, 0, ',', '.') }}</td>
                            <td class="px-8 py-6 text-sm font-medium">{{ Str::limit($property->description, 50) }}</td>
                            <td class="px-8 py-6 text-sm font-medium">
                                @if ($property->images_url->isNotEmpty())
                                    <img src="{{ Storage::url($property->images_url->first()->image_url) }}" 
                                        alt="Foto Properti" class="rounded-lg shadow-md w-24 h-24 object-cover">
                                @else
                                    <span class="text-gray-400">N/A</span>
                                @endif
                            </td>
                            <td class="px-8 py-6 text-sm font-medium">
                                <div class="flex space-x-4">
                                    <a href="{{ route('properties.show', $property->id) }}" class="text-blue-600 hover:text-blue-800 transition duration-300">Detail</a>
                                    <a href="{{ route('properties.edit', $property->id) }}" class="text-yellow-600 hover:text-yellow-800 transition duration-300">Edit</a>
                                    <form action="{{ route('properties.destroy', $property->id) }}" method="POST" class="inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="text-red-600 hover:text-red-800 transition duration-300 btn-delete">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Button to add new property -->
        <div class="mt-8 flex justify-center">
            <a href="{{ route('properties.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-8 py-4 rounded-full text-lg font-semibold shadow-lg hover:shadow-xl transition duration-300">
                Tambah Properti
            </a>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function () {
                const form = this.closest('form');

                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data yang dihapus tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e3342f',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush

