<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Kriteria Baru</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm rounded-lg">
                <form action="{{ route('criteria.store') }}" method="POST">
                    @csrf 
                    
                    <div class="mb-4">
                        <label class="block mb-2 font-bold text-gray-700">Nama Kriteria</label>
                        <input type="text" name="name" class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Contoh: Pengalaman Kerja" required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-bold text-gray-700">Bobot (%)</label>
                        <input type="number" step="0.01" name="weight" class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Contoh: 20" required>
                        <p class="text-xs text-gray-500 mt-1">*Masukkan angka 1-100 (Total seluruh kriteria harus 100)</p>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-bold text-gray-700">Atribut</label>
                        <select name="attribute" class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="benefit">Benefit (Semakin besar semakin bagus)</option>
                            <option value="cost">Cost (Semakin kecil semakin bagus)</option>
                        </select>
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('criteria.index') }}" class="bg-red-500 text-white px-4 py-2 rounded mr-2 hover:bg-red-600">Batal</a>
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>