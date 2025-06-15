<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SIMDIK AUM KUTIM</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/rekapData.js'])
</head>

<body>
    <nav class="bg-white shadow-md h-20 px-4 flex items-center justify-between sticky top-0">
        <div>
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12">
        </div>

        <div>
            <a href="/pegawai/login"
                class="text-white bg-cyan-950 hover:bg-cyan-800 cursor-pointer text-sm rounded-full px-5 py-2">Login
                Pegawai</a>
        </div>
    </nav>

    <section class="flex flex-col items-center justify-center mt-10 px-4">
        <h1 class="text-3xl md:text-4xl font-bold text-cyan-950 mb-4 text-center">
            Rekapitulasi Data Pegawai SIMDIK Kutim
        </h1>
        <p class="text-base md:text-lg text-gray-700 text-center max-w-2xl">
            Berikut adalah rekap data pegawai berdasarkan masing-masing AUM. Data ini dapat membantu Anda dalam memantau
            distribusi dan jumlah pegawai di setiap unit.
        </p>

        <select id="aum" name="aum"
            class="block w-[20rem] mt-8 border-b border-cyan-900 px-3 py-2 outline-none font-medium text-gray-700">
            <option value="">Pilih AUM</option>
            @foreach ($aum as $item)
                <option value="{{ $item->id }}">{{ $item->namaAum }}</option>
            @endforeach
        </select>
    </section>

    <!-- Loading State -->
    <div id="loading-state" class="flex flex-col justify-center items-center w-full px-2 lg:px-8 mt-8 mb-12"
        style="display: none;">
        <div class="flex space-x-2 mb-2">
            <div class="w-3 h-3 bg-cyan-900 rounded-full animate-bounce"></div>
            <div class="w-3 h-3 bg-cyan-900 rounded-full animate-bounce [animation-delay:.2s]"></div>
            <div class="w-3 h-3 bg-cyan-900 rounded-full animate-bounce [animation-delay:.4s]"></div>
        </div>
        <span class="text-cyan-900 font-medium">Loading...</span>
    </div>

    <div class="justify-center items-center w-full px-2 lg:px-8 mt-8 mb-12 overflow-auto hidden" id="chart-container">
        <div class="w-full p-4 rounded shadow border border-gray-200"><canvas id="acquisitions"></canvas></div>
    </div>
</body>

</html>
