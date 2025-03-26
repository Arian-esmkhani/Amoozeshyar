<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>آموزش‌یار - ورود</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <nav class="bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <a href="{{ route('home') }}">
                                <img class="h-8 w-auto" src="{{ asset('images/logo.png') }}" alt="آموزش‌یار">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <main>
            {{ $slot }}
        </main>

        <footer class="bg-white border-t border-gray-100">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="text-center text-sm text-gray-500">
                    &copy; {{ date('Y') }} آموزش‌یار. تمامی حقوق محفوظ است.
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
