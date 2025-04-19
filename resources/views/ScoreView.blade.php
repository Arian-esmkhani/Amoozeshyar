<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <!-- تنظیمات متا و استایل‌های اصلی -->
    <!-- این بخش شامل تنظیمات اولیه صفحه و لینک‌های مورد نیاز است -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- فونت وزیر برای نمایش بهتر متون فارسی -->
    <link rel="stylesheet" href="https://cdn.fontcdn.ir/Font/Persian/Vazir/Vazir.css">
    <title>ارزشیابی اساتید - آموزش یار</title>
    <!-- لینک فایل‌های CSS و JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- استایل‌های Livewire -->
    @livewireStyles
    <style>
        body {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            min-height: 100vh;
            color: white;
        }
    </style>
</head>
<body class="font-vazir">
    <div class="min-h-screen flex flex-col">
        <header class="bg-white/5 backdrop-blur-lg border-b border-gray-800">
            <!-- کامپوننت هدر اصلی -->
            <x-main-head :userData="$data['userData']"/>
        </header>

        <main class="flex-grow container mx-auto px-4 py-8">
            <div class="max-w-4xl mx-auto">
                <!-- کامپوننت حساب -->
                <livewire:ScoreView :data="$data"/>
            </div>
        </main>

        <footer class="bg-white/5 backdrop-blur-lg border-t border-gray-800 mt-auto">
            <div class="container mx-auto px-4 py-6">
                <!-- کامپوننت فوتر -->
                <x-footer/>
            </div>
        </footer>
    </div>

    <!-- اسکریپت‌های Livewire -->
    @livewireScripts
</body>
</html>