<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>آموزش‌یار - احراز هویت</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-gray-900 to-black text-gray-300">
    <div class="min-h-screen flex flex-col">
        <nav class="bg-gray-900/80 backdrop-blur-sm border-b border-gray-700/40 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <a href="{{ route('home') }}">
                                <img class="h-8 w-auto" src="{{ asset('images/logo-dark.png') }}" alt="آموزش‌یار">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <main class="flex-grow">
            {{ $slot }}
        </main>

        <footer class="bg-gray-900/80 backdrop-blur-sm border-t border-gray-700/40">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                <div class="text-center text-sm text-gray-400">
                    &copy; {{ date('Y') }} آموزش‌یار. تمامی حقوق محفوظ است.
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
