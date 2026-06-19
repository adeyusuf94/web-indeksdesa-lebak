<?php

use App\Models\IndexVillage;
use Livewire\Component;

new class extends Component
{
    public $year;
    public $district;
    public $status;

    public function mount()
    {
        $this->year = date('Y');
    }

    public function updated($field)
    {
        // otomatis refresh data saat filter berubah
    }

    public function render()
    {

        return $this->layout('layouts::app');
    }
};
?>

<div class="p-6 space-y-6">

    <!-- GLOBAL FILTER -->
    <div class="bg-white p-4 rounded-xl shadow grid grid-cols-1 md:grid-cols-3 gap-4">

        <!-- Tahun -->
        <select wire:model.live="year" class="border rounded p-2">
            <option value="">Semua Tahun</option>
            <option value="2024">2024</option>
            <option value="2025">2025</option>
        </select>

        <!-- Kecamatan -->
        <select wire:model.live="district" class="border rounded p-2">
            <option value="">Semua Kecamatan</option>
            <option value="Bojonegoro">Bojonegoro</option>
            <option value="Sumberrejo">Sumberrejo</option>
        </select>

        <!-- Status IDM -->
        <select wire:model.live="status" class="border rounded p-2">
            <option value="">Semua Status</option>
            <option value="Tertinggal">Tertinggal</option>
            <option value="Berkembang">Berkembang</option>
            <option value="Maju">Maju</option>
            <option value="Mandiri">Mandiri</option>
        </select>

    </div>

    <!-- STAT CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <div class="bg-white p-5 rounded-xl shadow">
            <p class="text-gray-500 text-sm">Total Desa</p>
            <p class="text-3xl font-bold text-green-600">
                {{ $totalDesa }}
            </p>
        </div>

        <div class="bg-white p-5 rounded-xl shadow">
            <p class="text-gray-500 text-sm">Rata-rata IDM</p>
            <p class="text-3xl font-bold text-blue-600">
                {{ number_format($avgScore, 2) }}
            </p>
        </div>

        <div class="bg-white p-5 rounded-xl shadow">
            <p class="text-gray-500 text-sm">Tahun Aktif</p>
            <p class="text-xl font-semibold">
                {{ $year }}
            </p>
        </div>

    </div>

    <!-- TABLE DATA -->
    <div class="bg-white p-6 rounded-xl shadow">

        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 text-left">Desa</th>
                    <th class="p-2 text-left">Kecamatan</th>
                    <th class="p-2 text-left">Skor IDM</th>
                    <th class="p-2 text-left">Status</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($villages as $village)
                <tr class="border-b">
                    <td class="p-2">{{ $village->kode_kecamatan }}</td>
                    <td class="p-2">{{ $village->nama_kecamatan }}</td>
                    <td class="p-2 font-semibold">
                        {{ $village->indeks_desa->skor ?? '-' }}
                    </td>
                    <td class="p-2">
                        {{ $village->indeks_desa->status_indeks ?? '-' }}
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>

    </div>

</div>