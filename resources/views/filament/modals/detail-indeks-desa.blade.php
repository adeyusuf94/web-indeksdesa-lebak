<!-- {{-- resources/views/filament/modals/detail-indeks-desa.blade.php --}}

<x-filament::section>

    {{-- 🔷 HEADER --}}
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-2xl font-bold tracking-tight">
            Data Indeks Desa {{ $record->desa->nama_desa ?? 'Tidak Diketahui' }} Tahun {{$record->tahun ?? 'Tidak Diketahui'}}
        </h2>
    </div>

    {{-- 🔷 STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">

        <x-filament::card class="rounded-2xl shadow-sm">
            <div class="text-sm text-gray-500">Skor</div>
            <div class="text-3xl font-bold">
                {{ $record->skor ?? 0 }}
            </div>
        </x-filament::card>

        <x-filament::card class="rounded-2xl shadow-sm">
            <div class="text-sm text-gray-500">Status Desa</div>
            <div class="text-2xl font-semibold text-primary-600">
                {{ $record->status_indeks ?? 'Tidak Diketahui' }}
            </div>
        </x-filament::card>

    </div>

    {{-- 🔷 TABLE --}}
    <x-filament::card class="rounded-2xl shadow-sm">
        <div class="font-semibold mb-4">
            Detail Dimensi Indeks Desa
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm border rounded-lg overflow-hidden">

                <thead class="bg-gray-100 dark:bg-gray-800">
                    <tr>
                        <th class="p-3 text-left">Dimensi Layanan Dasar</th>
                        <th class="p-3 text-left">Dimensi Sosial</th>
                        <th class="p-3 text-left">Dimensi Ekonomi</th>
                        <th class="p-3 text-left">Dimensi Lingkungan</th>
                        <th class="p-3 text-left">Dimensi Aksesibilitas</th>
                        <th class="p-3 text-left">Dimensi Tata Kelola Pemerintahan</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                        <td class="p-3 text-center">{{ $record->dimensi_layanan_dasar ?? 'Tidak Diketahui' }}</td>
                        <td class="p-3 text-center">{{ $record->dimensi_sosial ?? 'Tidak Diketahui' }}</td>
                        <td class="p-3 text-center">{{ $record->dimensi_ekonomi ?? 'Tidak Diketahui' }}</td>
                        <td class="p-3 text-center">{{ $record->dimensi_lingkungan ?? 'Tidak Diketahui' }}</td>
                        <td class="p-3 text-center">{{ $record->dimensi_aksesibilitas ?? 'Tidak Diketahui' }}</td>
                        <td class="p-3 text-center">{{ $record->dimensi_tata_kelola_pemerintah ?? 'Tidak Diketahui' }}</td>
                    </tr>

                </tbody>

            </table>
        </div>

    </x-filament::card>

</x-filament::section> -->