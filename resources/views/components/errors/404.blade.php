<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>404 - Halaman Tidak Ditemukan</title>
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

            <!-- ICON 404 -->
            <i class="fa-solid fa-circle-exclamation text-yellow-600 text-8xl mb-8"></i>

            <h1 class="text-8xl font-black text-gray-900 mb-3 tracking-tighter">404</h1>
            <h2 class="text-3xl font-bold text-yellow-600 mb-4 uppercase tracking-wider">Halaman Tidak Ditemukan</h2>

            <p class="text-gray-600 mb-10 text-lg leading-relaxed">
                Link yang Anda ikuti mungkin rusak, atau halaman telah dihapus. Kami tidak dapat menemukan apa yang Anda
                cari.
            </p>

            <a href="/"
                class="inline-flex items-center justify-center px-10 py-3 border-2 border-indigo-600 text-base font-semibold
                   rounded-full text-white bg-indigo-600 transition-all duration-300 ease-in-out transform
                   hover:scale-105 hover:bg-white hover:text-indigo-600 shadow-lg hover:shadow-xl">

                <i class="fa-solid fa-house mr-2"></i>
                Kembali ke Beranda
            </a>
        </div>

    </body>

</html>
