<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Kandidat Baru</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm rounded-lg">
                <form action="{{ route('alternatives.store') }}" method="POST">
                    @csrf <div class="mb-4">
                        <label class="block mb-2 font-bold text-gray-700">Nama Kandidat</label>
                        <input type="text" name="name" class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Contoh: Budi Santoso" required>
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('alternatives.index') }}" class="bg-red-500 text-white px-4 py-2 rounded mr-2 hover:bg-red-600">Batal</a>
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>