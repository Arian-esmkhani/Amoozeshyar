<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <!-- تنظیمات متا و استایل‌های اصلی -->
    <!-- این بخش شامل تنظیمات اولیه صفحه و لینک‌های مورد نیاز است -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- فونت وزیر برای نمایش بهتر متون فارسی -->
    <link rel="stylesheet" href="https://cdn.fontcdn.ir/Font/Persian/Vazir/Vazir.css">
    <title>انتخاب واحد - آموزش یار</title>
    <!-- لینک فایل‌های CSS و JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- استایل‌های Livewire -->
    @livewireStyles
</head>
<body class="bg-gradient-to-br from-gray-900 to-black min-h-screen font-vazir">
    <!-- ساختار اصلی صفحه -->
    <!-- این بخش شامل هدر، محتوای اصلی و فوتر است -->
    <div class="min-h-screen flex flex-col">
        <!-- هدر سایت -->
        <!-- این بخش شامل منوی اصلی و اطلاعات کاربر است -->
        <header class="fixed top-0 left-0 right-0 z-50 bg-gradient-to-b from-black/80 to-transparent backdrop-blur-md">
            <!-- کامپوننت هدر اصلی -->
            <x-main-head :userData="$data['userData']"/>
        </header>

        <!-- محتوای اصلی -->
        <!-- این بخش شامل کامپوننت انتخاب واحد است -->
        <main class="flex-grow container mx-auto px-4 pt-24 pb-12">
            <!-- کامپوننت انتخاب واحد -->
            <livewire:entekhab-vahed :data="$data" />
        </main>

        <!-- فوتر سایت -->
        <!-- این بخش شامل اطلاعات تماس و لینک‌های مفید است -->
        <footer class="bg-gradient-to-t from-black to-gray-900 text-white py-8 mt-12">
            <div class="container mx-auto px-4">
                <!-- کامپوننت فوتر -->
                <x-footer/>
            </div>
        </footer>
    </div>

    <!-- اسکریپت‌های Livewire -->
    @livewireScripts
</body>
</html>
