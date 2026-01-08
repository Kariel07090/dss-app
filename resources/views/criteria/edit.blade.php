<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Kriteria</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm rounded-lg">
                <form action="{{ route('criteria.update', $criterion->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-4">
                        <label class="block mb-1">Nama Kriteria</label>
                        <input type="text" name="name" value="{{ $criterion->name }}" class="w-full border rounded p-2" required>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-2 font-bold text-gray-700">Bobot (%)</label>
                        <input type="number" step="0.01" name="weight" value="{{ $criterion->weight }}" class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1">Atribut</label>
                        <select name="attribute" class="w-full border rounded p-2">
                            <option value="benefit" {{ $criterion->attribute == 'benefit' ? 'selected' : '' }}>Benefit</option>
                            <option value="cost" {{ $criterion->attribute == 'cost' ? 'selected' : '' }}>Cost</option>
                        </select>
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>