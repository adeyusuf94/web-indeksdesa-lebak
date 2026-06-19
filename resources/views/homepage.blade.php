<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIAP Desa - Indeks Desa</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @filamentStyles
</head>

<body class="bg-gray-100 font-sans antialiased">

    <!-- Navbar -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-green-500 rounded"></div>
                <h1 class="text-lg md:text-xl font-semibold text-gray-700">
                    SIAP Desa - Indeks Desa
                </h1>
            </div>

            <div class="flex items-center gap-4">
                <a href="#" class="text-gray-600 hover:text-gray-900">Kontak</a>
                <a href="/admin" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm">Login</a>
            </div>
        </div>
    </header>

    <!-- Main -->
    <main class="max-w-6xl mx-auto px-4 md:px-6 mt-8">

        <div class="bg-gray-200 rounded-2xl p-6">

            <!-- Title -->
            <h2 class="text-gray-700 font-semibold mb-4">
                Rekap IDM Kabupaten
            </h2>

            <!-- Cards -->
            <div class="grid md:grid-cols-2 gap-6">

                <!-- Card Skor -->
                <div class="bg-gradient-to-r from-cyan-500 to-cyan-600 text-white rounded-2xl p-6">
                    <h3 class="text-2xl font-bold">
                        0.8412705989316968
                    </h3>
                    <p class="text-sm mt-2 opacity-90">
                        Skor IDM Saat Ini
                    </p>
                </div>

                <!-- Card Status -->
                <div class="bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-2xl p-6">
                    <h3 class="text-2xl font-bold">
                        MANDIRI
                    </h3>
                    <p class="text-sm mt-2 opacity-90">
                        Status IDM
                    </p>
                </div>

            </div>

        </div>


    </main>

    <!-- Footer -->
    <footer class="mt-16 bg-white border-t">
        <div class="max-w-6xl mx-auto px-6 py-10 grid md:grid-cols-2 gap-8">

            <div>
                <h2 class="text-lg font-semibold text-gray-700 mb-2">
                    SIAP Desa - Indeks Desa Membangun
                </h2>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Sistem Informasi Administrasi Pemerintahan Desa<br>
                    Dinas Pemberdayaan Masyarakat Desa<br>
                    Kabupaten Bojonegoro
                </p>
            </div>

            <div>
                <h3 class="text-sm font-semibold text-gray-700 mb-2">KONTAK</h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Jln. Panglima Sudirman No.161<br>
                    Telp: (0353) 881512<br>
                    Email: dinpmd@bojonegorokab.go.id
                </p>
            </div>

        </div>

        <div class="text-center text-xs text-gray-500 pb-6">
            © 2021 | Admin - Dinas PMD Bojonegoro
        </div>
    </footer>

    @livewireScripts
    @filamentScripts

</body>

</html>