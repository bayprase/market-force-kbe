<?php

use Livewire\Component;
use App\Services\APIService;

new class extends Component
{
    public $stats = [];
    public $program = '';
    public $nama = '';
    public $tanggal = '';
    public $page = 1;
    public $loading = true;

    public function mount(APIService $api)
    {
        $this->loadData($api);
    }

    public function loadData(APIService $api)
    {
        $this->loading = true;

        $filters = [
            'program_nama' => $this->program,
            'nama_lengkap' => $this->nama,
            'tanggal' => $this->tanggal,
        ];

        $this->stats = $api->getStats($this->page, $filters);

        $this->loading = false;
    }

    public function gotoPage($page, APIService $api)
    {
        if ($this->page == $page) return;

        $this->page = $page;

        $this->loadData($api);

        $this->dispatch('scroll-top');
    }

    public function updatedProgram(APIService $api)
    {
        $this->resetPage();
        $this->loadData($api);
    }

    public function updatedNama(APIService $api)
    {
        $this->resetPage();
        $this->loadData($api);
    }

    public function updatedTanggal(APIService $api)
    {
        $this->resetPage();
        $this->loadData($api);
    }

    private function resetPage()
    {
        $this->page = 1;
    }

    public function export(APIService $api)
    {
        $filters = [
            'program_nama' => $this->program,
            'nama_lengkap' => $this->nama,
            'tanggal' => $this->tanggal,
        ];

        return redirect()->away($api->exportStats($filters));
    }
};

?>

<div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 w-full p-6">
        @forelse ($stats['totalSiswaPerBrand'] as $index => $countSiswa)
        <div class="col-span-1 bg-amber-50 shadow h-fit p-4 rounded-md">
            <p class="text-xl font-bold text-emerald-500">{{ $index }}</p>
            <p class="text-md font-bold text-yellow-400">{{ $countSiswa }} Siswa</p>
        </div>
        @empty
        <p class="text-2xl text-gray-400">Belum ada data apapun disini.</p>
        @endforelse
    </div>
    
    <div class="grid grid-cols-1 p-6 w-full">
        <div class="col-span-1 bg-white shadow p-4 rounded-md">
            <div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base">
                <p class="text-2xl">Statistik Sesi Siswa</p>

                <div class="grid grid-cols-4 gap-4 mb-4">
                    <input type="text"
                        wire:model.live.debounce.500ms="program"
                        placeholder="Filter Program"
                        class="border rounded px-3 py-2" />

                    <input type="text"
                        wire:model.live.debounce.500ms="nama"
                        placeholder="Filter Nama"
                        class="border rounded px-3 py-2" />

                    <input type="date"
                        wire:model.live.debounce.500ms="tanggal"
                        class="border rounded px-3 py-2" />

                    <button wire:click="loadData"
                        class="bg-blue-600 text-white px-4 py-2 rounded">
                        Filter
                    </button>
                </div>

                <div class="col-span-1 bg-blue-50 shadow h-fit p-4 rounded-md mb-4">
                    <div class="grid grid-cols-1 md:grid-cols-[2fr_0.1fr]">
                        <div class="col-span-1">
                            <p class="text-xl font-bold text-blue-600">
                                @php
                                    if($nama != ''){
                                        echo 'Ditemukan siswa bernama. '. "<b>".$nama."</b>";
                                    }
        
                                    if($program != ''){
                                        echo 'Total siswa '. '<b>'.$program.'</b>';
                                    }
        
                                    if($program == '' && $nama == ''){
                                        echo 'Total seluruh siswa';
                                    }
                                @endphp
                            </p>
                            <p class="text-md font-bold text-blue-800">
                                {{ $stats['totalFiltered'] ?? 0 }} Siswa
                            </p>
                        </div>
                        <div class="col-span-1 flex justify-center items-center">
                            <button wire:click="export" class="border border-gray-400 hover:border-0 hover:text-white hover:bg-green-800 py-2 px-3 rounded-md flex gap-2 items-center">
                                Download <i class="fa-solid fa-file-csv"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <table class="border-collapse border border-gray-400 w-full rounded">
                    <thead>
                        <tr>
                            <th scope="col" class="px-3 py-2 w-16 text-center">No.</th>
                            <th scope="col" class="px-3 py-2 ">
                                <div class="flex items-center justify-between cursor-pointer" id="sort-nama-siswa">
                                    <span>Nama Siswa</span>
                                    <span class="sort-icon ml-2 hover:text-cyan-600 transition-colors">
                                        <i class="fas fa-sort-alpha-up text-gray-400"></i>
                                    </span>
                                </div>
                            </th>
                            <th scope="col" class="px-3 py-2 w-28 text-center">Limit Sesi</th>
                            <th scope="col" class="px-3 py-2 w-32 text-center">Sesi Terlaksana</th>
                            <th scope="col" class="px-3 py-2 w-28 text-center">
                                <div class="flex items-center justify-between" id="sort-remaining-sessions">
                                    <span>Sisa Sesi</span>
                                    <span class="sort-icon ml-2 cursor-pointer hover:text-cyan-600 transition-colors">
                                        <i class="fas fa-sort-amount-up text-cyan-600"></i>
                                    </span>
                                </div>
                            </th>
                            <th scope="col" class="px-3 py-2 w-32 text-center">Status</th>
                            <th scope="col" class="px-3 py-2 w-32 text-center">Kelas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($stats['studentSessionStats']['data'] ?? [] as $index => $students)
                            @php
                                $rowNumber = ($stats['studentSessionStats']['from'] ?? 1) + $index;
                                $sesi = $students['session_limit'] / 2;
                            @endphp
                            <tr class="hover:bg-gray-50 transition">

                                <td class="border text-center font-semibold">
                                    {{ $rowNumber }}
                                </td>

                                <td class="border px-3">
                                    {{ Illuminate\Support\Str\Str::title($students['nama_lengkap']) }}
                                </td>

                                <td class="border text-center">
                                    {{ $students['completed_sessions'] + $students['session_limit'] }}
                                </td>

                                <td class="border text-center">
                                    {{ $students['completed_sessions'] }}
                                </td>

                                <td class="border text-center">
                                    {{ $students['session_limit'] }}
                                </td>

                                <td class="border text-center">

                                    @if($students['session_limit'] > 0)
                                        <span class="text-green-600 font-semibold">Aktif</span>
                                    @elseif($students['session_limit'] == 0)
                                        <span class="text-red-500 font-semibold">Selesai</span>
                                    @else
                                        <span class="text-yellow-600 font-semibold">Hold</span>
                                    @endif

                                </td>

                                <td class="border text-center">
                                    {{ $students['program_nama'] }}
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-6 text-gray-400">
                                    Belum ada data siswa.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="flex justify-center gap-2 mt-6 flex-wrap">
                    @foreach($stats['studentSessionStats']['links'] ?? [] as $link)
                        @php
                            $pageNumber = null;
                            if ($link['url']) {
                                parse_str(parse_url($link['url'], PHP_URL_QUERY), $query);
                                $pageNumber = $query['page'] ?? null;
                            }
                        @endphp
                        @if($pageNumber)
                            <button
                                wire:click="gotoPage({{ $pageNumber }})"
                                wire:loading.attr="disabled"
                                wire:target="gotoPage({{ $pageNumber }})"
                                class="px-3 py-1 rounded border text-sm transition hover:cursor-pointer
                                {{ $link['active']
                                    ? 'bg-blue-600 text-white border-blue-600'
                                    : 'bg-white hover:bg-gray-100'
                                }}">
                                <span wire:loading.remove wire:target="gotoPage({{ $pageNumber }})">
                                    {!! $link['label'] !!}
                                </span>
                                <span wire:loading wire:target="gotoPage({{ $pageNumber }})">
                                    <svg class="animate-spin h-4 w-4 inline" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4" fill="none" opacity="0.25"></circle>
                                        <path fill="currentColor"
                                            d="M4 12a8 8 0 018-8v4l3-3-3-3v4a10 10 0 00-10 10h2z">
                                        </path>
                                    </svg>
                                </span>
                            </button>
                        @else
                            <span class="px-3 py-1 text-gray-400 text-sm">
                                {!! $link['label'] !!}
                            </span>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script>
Livewire.on('scroll-top', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
});
</script>