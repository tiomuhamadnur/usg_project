<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>419 - Page Expired</title>
        <link rel="shortcut icon" href="{{ asset('assets/img/ukt1logo.png') }}" />
        <script src="https://cdn.tailwindcss.com"></script>

        <!-- FONT AWESOME -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

        <style>
            body {
                font-family: 'Inter', sans-serif;
            }
        </style>
    </head>

    <body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">

        <div
            class="text-center max-w-xl w-full p-10 bg-white rounded-2xl shadow-xl border border-gray-200
                transition-all duration-500 hover:shadow-2xl">

            <!-- CLOCK / PAGE EXPIRED ICON -->
            <i class="fa-solid fa-clock-rotate-left text-yellow-500 text-8xl mb-8"></i>

            <h1 class="text-8xl font-black text-gray-900 mb-3 tracking-tighter">419</h1>
            <h2 class="text-3xl font-bold text-yellow-600 mb-4 uppercase tracking-wider">Page Expired</h2>

            <p class="text-gray-600 mb-10 text-lg leading-relaxed">
                Sistem mendeteksi sudah lama tidak ada aktivitas di halaman ini.
                Silakan refresh halaman atau ulangi permintaan Anda.
            </p>

            <div class="flex justify-center gap-4">
                <a href="{{ url()->previous() }}"
                    class="inline-flex items-center justify-center px-10 py-3 border-2 border-yellow-500 text-base font-semibold
                       rounded-full text-white bg-yellow-500 transition-all duration-300 ease-in-out transform
                       hover:scale-105 hover:bg-white hover:text-yellow-600 shadow-lg hover:shadow-xl">

                    <i class="fa-solid fa-arrow-left mr-2"></i>
                    Kembali
                </a>

                <a href="{{ url('/') }}"
                    class="inline-flex items-center justify-center px-10 py-3 border-2 border-indigo-600 text-base font-semibold
                       rounded-full text-white bg-indigo-600 transition-all duration-300 ease-in-out transform
                       hover:scale-105 hover:bg-white hover:text-indigo-600 shadow-lg hover:shadow-xl">

                    <i class="fa-solid fa-house mr-2"></i>
                    Beranda
                </a>
            </div>
        </div>

    </body>

</html>
