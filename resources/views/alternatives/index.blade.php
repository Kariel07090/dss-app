<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Data Alternatif</h2>
    </x-slot>

    <div class="py-12" 
         x-data="{ 
            showAddModal: {{ $errors->hasBag('default') && !$errors->has('id') ? 'true' : 'false' }}, 
            showEditModal: {{ $errors->hasBag('default') && $errors->has('id') ? 'true' : 'false' }},
            showDeleteModal: false,
            showDeleteAllModal: false,
            deleteAction: '',
            editData: { id: '', name: '', action: '' }
         }">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
            <div x-data="{ show: true }" 
                 x-show="show" 
                 x-init="setTimeout(() => show = false, 3000)" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 transform translate-y-0"
                 x-transition:leave-end="opacity-0 transform -translate-y-2"
                 class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg shadow-md relative flex items-center gap-2" role="alert">
                
                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                
                <div>
                    <strong class="font-bold">Sukses!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>

                <button @click="show = false" class="absolute top-0 bottom-0 right-0 px-4 py-3 text-green-500 hover:text-green-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-4">
                    
                    <div class="flex gap-2">
                        <button @click="showAddModal = true" class="bg-blue-600 text-white px-4 py-2 rounded inline-flex items-center hover:bg-blue-700 transition shadow-sm hover:shadow-lg transform hover:-translate-y-0.5 duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Tambah Kandidat
                        </button>

                        @if($alternatives->total() > 0)
                        <button @click="showDeleteAllModal = true" class="bg-red-600 text-white px-4 py-2 rounded inline-flex items-center hover:bg-red-700 transition shadow-sm hover:shadow-lg transform hover:-translate-y-0.5 duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Hapus Semua
                        </button>
                        @endif
                    </div>

                    <div class="bg-indigo-50 text-indigo-700 px-4 py-2 rounded-lg text-sm font-bold shadow-sm border border-indigo-100 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Total Kandidat: {{ $alternatives->total() }}
                    </div>
                </div>

                <table class="w-full border-collapse border border-gray-200 mt-2 text-sm">
                    <thead class="bg-gray-100 text-gray-700 uppercase">
                        <tr>
                            <th class="border p-3">Nama Kandidat</th>
                            <th class="border p-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($alternatives as $a)
                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                            <td class="border p-3 font-medium text-gray-800">{{ $a->name }}</td>
                            <td class="border p-3 text-center">
                                <div class="flex justify-center items-center gap-2">
                                    <button @click="
                                            showEditModal = true;
                                            editData.id = '{{ $a->id }}';
                                            editData.name = '{{ $a->name }}';
                                            editData.action = '{{ route('alternatives.update', $a->id) }}';
                                        " class="text-yellow-500 hover:text-yellow-700 p-1.5 border border-yellow-500 rounded hover:bg-yellow-50 transition duration-200" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                    </button>

                                    <button @click="showDeleteModal = true; deleteAction = '{{ route('alternatives.destroy', $a->id) }}'" 
                                            class="text-red-500 hover:text-red-700 p-1.5 border border-red-500 rounded hover:bg-red-50 transition duration-200" title="Hapus">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="px-6 py-8 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    <p class="font-medium">Belum ada data kandidat.</p>
                                    <p class="text-xs mt-1 text-gray-400">Silakan klik tombol "Tambah Kandidat" di atas.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4 px-4 pb-4">
                    {{ $alternatives->links() }}
                </div>
            </div>
        </div>

        <div x-show="showAddModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm" 
                 x-show="showAddModal"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="showAddModal = false"></div>

            <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
                <div x-show="showAddModal"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative bg-white rounded-xl shadow-2xl transform transition-all sm:my-8 sm:max-w-lg w-full overflow-hidden">
                     
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 border-b border-blue-500 flex justify-between items-center">
                        <h3 class="font-bold text-white text-lg flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Kandidat
                        </h3>
                        <button @click="showAddModal = false" class="text-white hover:text-gray-200 transition transform hover:rotate-90 duration-300 p-1 rounded-full hover:bg-blue-500/20">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <div class="p-6 text-left">
                        <form action="{{ route('alternatives.store') }}" method="POST">
                            @csrf 
                            <div class="mb-6">
                                <label class="block mb-2 font-semibold text-sm text-gray-700">Nama Kandidat</label>
                                <input type="text" name="name" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition" required>
                            </div>
                            <div class="flex justify-end gap-3">
                                <button type="button" @click="showAddModal = false" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">Batal</button>
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5 font-medium">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="showEditModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm" 
                 x-show="showEditModal"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="showEditModal = false"></div>

            <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
                <div x-show="showEditModal"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative bg-white rounded-xl shadow-2xl transform transition-all sm:my-8 sm:max-w-lg w-full overflow-hidden">
                    
                    <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 px-6 py-4 border-b border-yellow-400 flex justify-between items-center">
                        <h3 class="font-bold text-white text-lg flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            Edit Kandidat
                        </h3>
                        <button @click="showEditModal = false" class="text-white hover:text-gray-100 transition transform hover:rotate-90 duration-300 p-1 rounded-full hover:bg-yellow-400/20">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <div class="p-6 text-left">
                        <form :action="editData.action" method="POST">
                            @csrf @method('PUT')
                            <input type="hidden" name="id" :value="editData.id">

                            <div class="mb-6">
                                <label class="block mb-2 font-semibold text-sm text-gray-700">Nama Kandidat</label>
                                <input type="text" name="name" :value="editData.name" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-yellow-500 focus:border-yellow-500 transition" required>
                            </div>
                            <div class="flex justify-end gap-3">
                                <button type="button" @click="showEditModal = false" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">Batal</button>
                                <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5 font-medium">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="showDeleteModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            
            <div class="fixed inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm" 
                 x-show="showDeleteModal"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="showDeleteModal = false"></div>

            <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
                <div x-show="showDeleteModal"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative bg-white rounded-xl shadow-2xl transform transition-all sm:my-8 sm:max-w-md w-full overflow-hidden">
                    
                    <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4 border-b border-red-500 flex justify-between items-center">
                        <h3 class="font-bold text-white text-lg flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            Konfirmasi Hapus
                        </h3>
                        <button @click="showDeleteModal = false" class="text-white hover:text-red-100 transition transform hover:rotate-90 duration-300 p-1 rounded-full hover:bg-red-500/20">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <div class="p-6 text-center">
                        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
                            <svg class="h-10 w-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Hapus kandidat ini?</h3>
                        <p class="text-sm text-gray-500 mt-2">
                            Data kandidat beserta <strong>seluruh nilai penilaiannya</strong> akan dihapus permanen.
                        </p>

                        <div class="mt-6 flex justify-center gap-3">
                            <button type="button" @click="showDeleteModal = false" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">
                                Batal
                            </button>
                            
                            <form :action="deleteAction" method="POST">
                                @csrf 
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5 font-medium flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Ya, Hapus Data
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="showDeleteAllModal" class="fixed inset-0 z-[60] overflow-y-auto" style="display: none;">
            
            <div class="fixed inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm" 
                 x-show="showDeleteAllModal"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="showDeleteAllModal = false"></div>

            <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
                <div x-show="showDeleteAllModal"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative bg-white rounded-xl shadow-2xl transform transition-all sm:my-8 sm:max-w-md w-full overflow-hidden">
                    
                    <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4 border-b border-red-500 flex justify-between items-center">
                        <h3 class="font-bold text-white text-lg flex items-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            Konfirmasi Hapus Semua
                        </h3>
                        <button @click="showDeleteAllModal = false" class="text-white hover:text-red-100 transition transform hover:rotate-90 duration-300 p-1 rounded-full hover:bg-red-500/20">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <div class="p-6 text-center">
                        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
                            <svg class="h-10 w-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        </div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Kosongkan Semua Kandidat?</h3>
                        <p class="text-sm text-gray-500 mt-2">Seluruh data kandidat beserta nilai penilaiannya akan dihapus permanen dari sistem.</p>
                        <div class="mt-6 flex justify-center gap-3">
                            <button @click="showDeleteAllModal = false" class="px-4 py-2 bg-gray-100 rounded-lg text-sm font-medium">Batal</button>
                            <form action="{{ route('alternatives.deleteAll') }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-bold shadow-md hover:bg-red-700 transition transform hover:-translate-y-0.5 font-medium flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Ya, Hapus Semua
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>