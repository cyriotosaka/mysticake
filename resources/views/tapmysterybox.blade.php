<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'MYstiCake') }}</title>
        
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        @include('partials.theme-script')
        
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="mysticake-body">
        <div class="mysticake-container">
            <!-- Main Content -->
            <main class="tap-mysterybox-content">
                <h2 class="mysterybox-title-simple">Normal<br>Mystery Box</h2>

                <!-- Mystery Box Interactive -->
                <div class="mysterybox-interactive">
                    <button class="mysterybox-tap-area" id="mysteryBoxTap">
                        <img src="{{ asset('images/mystery-box-open.png') }}" alt="Mystery Box" class="mysterybox-image-large">
                    </button>
                </div>

                <!-- Instruction Text -->
                <p class="tap-instruction">Tap the Mystery Box !</p>
            </main>
        </div>

        <script>
            document.getElementById('mysteryBoxTap')?.addEventListener('click', function() {
                this.classList.add('tap-animation');
                setTimeout(() => {
                    this.classList.remove('tap-animation');
                }, 300);
            });
        </script>
    </body>
</html>