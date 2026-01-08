<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
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
                 class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg shadow-md relative flex items-center gap-2 z-50" role="alert">
                
                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                
                <div>
                    <strong class="font-bold">Berhasil!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>

                <button @click="show = false" class="absolute top-0 bottom-0 right-0 px-4 py-3 text-green-500 hover:text-green-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            @endif
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 mb-8">
    <div class="p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            Visualisasi Skor Kandidat
        </h3>
        <div class="relative h-[300px] md:h-[400px]">
            <canvas id="rankingChart"></canvas>
        </div>
    </div>
</div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 mb-8">
                <div class="p-6 md:p-8">
                    
                   <div class="flex flex-col md:flex-row items-center justify-between mb-10 gap-4 border-b border-gray-100 pb-4">
    <div>
        <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
            <span class="text-2xl">🏆</span> Hasil Perankingan Akhir
        </h3>
        <p class="text-gray-500 text-sm mt-1">Metode Simple Additive Weighting (SAW)</p>
    </div>
    
    <div class="flex items-center gap-3">
        <div class="bg-indigo-50 text-indigo-700 px-4 py-2 rounded-lg text-sm font-bold shadow-sm border border-indigo-100">
            Total Kandidat: {{ $ranks->count() }}
        </div>
        
        <a href="{{ route('download.pdf') }}" class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-md transition-all hover:scale-105 active:scale-95">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Cetak PDF
        </a>
    </div>
</div>

                    @if($ranks->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12 items-end max-w-4xl mx-auto">
                        @if(isset($ranks[1]))
                        <div class="order-2 md:order-1 relative group text-center">
                            <div class="bg-white border-t-4 border-gray-400 shadow-lg rounded-xl p-5 transform hover:-translate-y-1 transition duration-300">
                                <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3 border-2 border-gray-300">
                                    <span class="text-lg font-bold text-gray-600">2</span>
                                </div>
                                <h4 class="text-base font-bold text-gray-800 truncate">{{ $ranks[1]['name'] }}</h4>
                                <div class="bg-gray-50 rounded px-3 py-1 mt-2 inline-block border border-gray-200">
                                    <span class="text-base font-extrabold text-gray-700">{{ number_format($ranks[1]['value'], 3) }}</span>
                                </div>
                            </div>
                        </div>
                        @endif

                       @if(isset($ranks[0]))
<div class="order-1 md:order-2 relative group -mt-6 md:-mt-10 text-center">
    <div class="bg-white border-t-4 border-yellow-400 shadow-2xl rounded-xl p-8 transform hover:-translate-y-2 transition duration-300 ring-1 ring-yellow-50 relative">
        
        <div class="absolute -top-5 left-1/2 transform -translate-x-1/2 z-20">
            <svg class="w-10 h-10 text-yellow-500 drop-shadow-md animate-bounce" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
        </div>

        <div class="w-16 h-16 bg-yellow-50 rounded-full flex items-center justify-center mx-auto mb-3 border-2 border-yellow-400 relative z-10">
            <span class="text-2xl font-bold text-yellow-600">1</span>
        </div>
        <h4 class="text-xl font-bold text-gray-900 truncate">{{ $ranks[0]['name'] }}</h4>
        <div class="bg-yellow-50 rounded-lg px-4 py-2 mt-2 inline-block border border-yellow-200">
            <span class="text-2xl font-extrabold text-yellow-700">{{ number_format($ranks[0]['value'], 3) }}</span>
        </div>
    </div>
</div>
@endif

                        @if(isset($ranks[2]))
                        <div class="order-3 relative group text-center">
                            <div class="bg-white border-t-4 border-orange-400 shadow-lg rounded-xl p-5 transform hover:-translate-y-1 transition duration-300">
                                <div class="w-12 h-12 bg-orange-50 rounded-full flex items-center justify-center mx-auto mb-3 border-2 border-orange-300">
                                    <span class="text-lg font-bold text-orange-600">3</span>
                                </div>
                                <h4 class="text-base font-bold text-gray-800 truncate">{{ $ranks[2]['name'] }}</h4>
                                <div class="bg-gray-50 rounded px-3 py-1 mt-2 inline-block border border-gray-200">
                                    <span class="text-base font-extrabold text-gray-700">{{ number_format($ranks[2]['value'], 3) }}</span>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif

                    <div class="overflow-hidden border border-gray-200 rounded-lg">
                        <table class="w-full text-sm text-left text-gray-600">
                            <thead class="bg-gray-50 text-gray-700 uppercase font-bold text-xs">
                                <tr>
                                    <th class="px-6 py-4 w-16 text-center">#</th>
                                    <th class="px-6 py-4">Nama Kandidat</th>
                                    <th class="px-6 py-4">Skor Akhir</th>
                                    <th class="px-6 py-4 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($paginatedRanks as $index => $rank)
                                @php
                                    // Hitung nomor urut absolut berdasarkan halaman
                                    $absoluteNumber = $paginatedRanks->firstItem() + $index;
                                @endphp
                                <tr class="bg-white hover:bg-gray-50 transition {{ $absoluteNumber <= 3 ? 'bg-yellow-50/10' : '' }}">
                                    <td class="px-6 py-4 text-center">
                                        @if($absoluteNumber == 1)
                                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-yellow-100 text-yellow-700 text-xs font-bold ring-1 ring-yellow-300">1</span>
                                        @elseif($absoluteNumber == 2)
                                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-gray-100 text-gray-700 text-xs font-bold ring-1 ring-gray-300">2</span>
                                        @elseif($absoluteNumber == 3)
                                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-orange-100 text-orange-700 text-xs font-bold ring-1 ring-orange-300">3</span>
                                        @else
                                            <span class="text-gray-400 font-medium">{{ $absoluteNumber }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $rank['name'] }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <span class="font-bold text-blue-600 w-12">{{ number_format($rank['value'], 3) }}</span>
                                            <div class="w-24 bg-gray-200 rounded-full h-1.5 overflow-hidden hidden sm:block">
                                                @php 
                                                    $maxVal = $ranks->max('value');
                                                    $percent = ($maxVal > 0) ? ($rank['value'] / $maxVal) * 100 : 0; 
                                                @endphp
                                                <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ $percent }}%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($absoluteNumber <= 3)
                                            <span class="bg-green-100 text-green-800 text-[10px] font-bold px-2 py-0.5 rounded border border-green-200 uppercase">Recommended</span>
                                        @else
                                            <span class="bg-gray-100 text-gray-500 text-[10px] font-bold px-2 py-0.5 rounded border border-gray-200 uppercase">Alternative</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $paginatedRanks->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-6 md:p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            Input Penilaian Kandidat
                        </h3>
                    </div>

                    <div class="overflow-x-auto border border-gray-200 rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="bg-gray-50 text-gray-700 uppercase font-bold text-xs">
                                <tr>
                                    <th class="px-6 py-4">Nama Kandidat</th>
                                    <th class="px-6 py-4 text-center">Status Input</th>
                                    <th class="px-6 py-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($alternatives as $a)
                                <tr class="bg-white hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $a->name }}</td>
                                    <td class="px-6 py-4 text-center">
                                        @if($a->evaluations->count() > 0)
                                            <span class="bg-emerald-100 text-emerald-700 text-xs font-bold px-2 py-1 rounded-md border border-emerald-200">Sudah Diisi</span>
                                        @else
                                            <span class="bg-gray-100 text-gray-500 text-xs font-bold px-2 py-1 rounded-md border border-gray-200">Belum Ada</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center" x-data="{ showInputModal: false }">
                                        <button @click="showInputModal = true" class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-xs px-4 py-2 transition shadow-sm">
                                            Input / Edit Nilai
                                        </button>

                                        <div x-show="showInputModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                                            <div x-show="showInputModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm" @click="showInputModal = false" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
                                            <div class="flex items-center justify-center min-h-screen p-4 text-left">
                                                <div x-show="showInputModal" class="relative bg-white rounded-xl shadow-2xl w-full max-w-lg overflow-hidden transform" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                                                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 flex justify-between items-center">
                                                        <h3 class="text-white font-bold text-lg">Input Nilai: {{ $a->name }}</h3>
                                                        <button @click="showInputModal = false" class="text-white hover:text-gray-100 transition transform hover:rotate-90 duration-300 p-1 rounded-full hover:bg-white/20 focus:outline-none">
                                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('evaluation.store') }}" method="POST" class="p-6">
                                                        @csrf
                                                        <input type="hidden" name="alternative_id" value="{{ $a->id }}">
                                                        <div class="grid grid-cols-1 gap-4 max-h-[60vh] overflow-y-auto pr-2">
                                                            @foreach($criteria as $c)
                                                            @php $val = $a->evaluations->firstWhere('criterion_id', $c->id)->value ?? ''; @endphp
                                                            <div>
                                                                <label class="block mb-1 text-sm font-semibold text-gray-700">{{ $c->name }} ({{ $c->attribute }})</label>
                                                                <input type="number" step="0.01" name="criteria[{{ $c->id }}]" value="{{ $val }}" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5" placeholder="0-100" required>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                        <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                                                            <button type="button" @click="showInputModal = false" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition">Batal</button>
                                                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 shadow-md transition">Simpan Data</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $alternatives->appends(request()->query())->links() }}
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Ambil data dari PHP variabel $ranks yang sudah dihitung
        // Kita hanya ambil 10 besar untuk grafik agar tidak terlalu penuh
        const rankData = @json($ranks->take(10));
        
        const labels = rankData.map(item => item.name);
        const scores = rankData.map(item => item.value.toFixed(3));

        const ctx = document.getElementById('rankingChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Skor Akhir SAW',
                    data: scores,
                    backgroundColor: 'rgba(79, 70, 229, 0.2)', // Warna indigo transparan
                    borderColor: 'rgba(79, 70, 229, 1)',      // Warna indigo solid
                    borderWidth: 2,
                    borderRadius: 5,
                    hoverBackgroundColor: 'rgba(79, 70, 229, 0.4)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100, // Karena biasanya skor SPK 0-100
                        grid: { borderDash: [5, 5] }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    });
</script>