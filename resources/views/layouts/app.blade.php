<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ session('theme', 'light') }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- ESTILO DO LIVEWIRE (ESSENCIAL) -->
    @livewireStyles

</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <livewire:layout.navigation />

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white dark:bg-gray-800 shadow dark:shadow-gray-700">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
    <!-- SCRIPTS DO LIVEWIRE (ESSENCIAL PARA O AJAX) -->
    @livewireScripts

    {{-- SCRIPT PARA ATUALIZAR O TEMA EM TEMPO REAL --}}
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('theme-changed', (event) => {
                // Remove as classes de tema existentes
                document.documentElement.classList.remove('light', 'dark');
                // Adiciona a nova classe de tema recebida do servidor
                document.documentElement.classList.add(event.theme);
            });
        });
    </script>
</body>

</html>
