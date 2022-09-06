<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0" style="background: url('{{ asset('static/img/home-menu-bg-overlay.svg') }}'), linear-gradient(to right bottom, #77717e, #c9a8a9)">
    <div>
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
</div>
