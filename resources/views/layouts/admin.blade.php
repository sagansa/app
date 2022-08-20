<!DOCTYPE html>
<html class="h-full bg-gray-100" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>app-sagansa</title>

    <!-- Styles -->
    {{-- <link rel="stylesheet" href="{{ mix('css/app.css') }}"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    <!-- Icons -->
    <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Scripts -->
    {{-- <script src="{{ mix('js/app.js') }}" defer></script> --}}

    <!-- Filepond stylesheet -->
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
        rel="stylesheet">

    {{-- <!-- Alpine -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script> --}}

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    @livewireStyles


</head>

<body wire:ignore class="h-full">

    <div x-data="{ isOpen: false }">

        @include('sidebar-mobile')

        <!-- Static sidebar for desktop -->
        {{-- @include('sidebar-desktop') --}}
        <div class="flex flex-col flex-1">
            @include('navbar')

            <!-- Page Heading -->
            @if (isset($header))
                <header>
                    <div class="px-2 pt-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <main class="flex-1">
                <div class="py-1">
                    {{-- <div class="px-4 mx-auto max-w-screen-2xl">
                        <h1 class="text-2xl font-semibold text-gray-900">@yield('title')</h1>
                    </div> --}}
                    <div class="px-4 mx-auto max-w-screen-2xl">
                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>
    </div>

    {{-- <x-notification /> --}}

    @stack('modals')

    <!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @livewireScripts

    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>

    @stack('scripts')

    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    <script src="https://unpkg.com/flowbite@1.3.4/dist/flowbite.js"></script>

    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.js"></script>

    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

    @if (session()->has('success'))
        <script>
            const notyf = new Notyf({
                dismissible: true
            })
            notyf.success('{{ session('success') }}')
        </script>
    @endif

    <script>
        /* Simple Alpine Image Viewer */
        document.addEventListener('alpine:init', () => {
            Alpine.data('imageViewer', (src = '') => {
                return {
                    imageUrl: src,

                    refreshUrl() {
                        this.imageUrl = this.$el.getAttribute("image-url")
                    },

                    fileChosen(event) {
                        this.fileToDataUrl(event, src => this.imageUrl = src)
                    },

                    fileToDataUrl(event, callback) {
                        if (!event.target.files.length) return

                        let file = event.target.files[0],
                            reader = new FileReader()

                        reader.readAsDataURL(file)
                        reader.onload = e => callback(e.target.result)
                    },
                }
            })
        })
    </script>

    <!-- Load FilePond library -->
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    {{-- <script src="filepond.js"></script> --}}


    {{-- <script>
        $('document').ready(function() {
            $('.product-enable').on('click', function() {
                let id = $(this).attr('data-id')
                let enabled = $(this).is(":checked")
                $('.product-quantity[data-id="' + id + '"]').attr('disabled', !enabled)
                $('.product-quantity[data-id="' + id + '"]').val(null)
            })
        });
    </script> --}}


    @yield('scripts')
</body>



</html>
