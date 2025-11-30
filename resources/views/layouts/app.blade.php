<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="font-poppins bg-gray-100">
    @yield('content')
    @hasSection('content.layout')
        <div class="flex h-screen overflow-hidden">
            @include('partials.sidebar')
            <div class="flex-1 flex flex-col overflow-hidden relative">
                @include('partials.navbar')
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
                    @yield('content.layout')
                </main>
            </div>
        </div>
    @endif
    @stack('modals')

    <script>
        function toggleModal(modalID){
            const modal = document.getElementById(modalID);
            const isHidden = modal.classList.contains('hidden');

            if (isHidden) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            } else {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }
    </script>

    @stack('scripts')
</body>

</html>
