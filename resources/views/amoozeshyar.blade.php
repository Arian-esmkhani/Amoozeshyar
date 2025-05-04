<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdn.fontcdn.ir/Font/Persian/Vazir/Vazir.css">
    <title>آموزش یار</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gradient-to-br from-gray-900 to-black min-h-screen font-vazir">
    <div class="min-h-screen flex flex-col">
        <header class="fixed top-0 left-0 right-0 z-50 bg-gradient-to-b from-black/80 to-transparent backdrop-blur-md">
            <x-main-head :userData="$userData"/>
        </header>

        <main class="flex-grow container mx-auto px-4 pt-24 pb-12">
        <livewire:amoozeshyar :userRole="$userRole"/>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                {{-- بخش نمایش اسلایدر اخبار --}}
                <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-purple-900/20 to-blue-900/20 backdrop-blur-sm border border-gray-800 shadow-2xl p-6">
                    <div class="absolute inset-0 bg-[url('/images/pattern.svg')] opacity-5"></div>
                    <div class="relative">
                        {{-- عنوان بخش --}}
                        <h2 class="text-xl font-bold text-white mb-4 bg-gradient-to-r from-purple-400 to-blue-400 bg-clip-text text-transparent">خبرها</h2>
                        {{-- استفاده از کامپوننت لایووایر اسلایدر برای نوع 'news' با بارگذاری تنبل --}}
                        <livewire:slider lazy
                            type="news"
                            title="آخرین اخبار"
                            viewAllLink="/khabar"
                        />
                    </div>
                </div>

                {{-- بخش نمایش اسلایدر اطلاعیه‌ها --}}
                <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-purple-900/20 to-blue-900/20 backdrop-blur-sm border border-gray-800 shadow-2xl p-6">
                    <div class="absolute inset-0 bg-[url('/images/pattern.svg')] opacity-5"></div>
                    <div class="relative">
                         {{-- عنوان بخش --}}
                        <h2 class="text-xl font-bold text-white mb-4 bg-gradient-to-r from-purple-400 to-blue-400 bg-clip-text text-transparent">اطلاعیه‌ها</h2>
                         {{-- استفاده از کامپوننت لایووایر اسلایدر برای نوع 'event' با بارگذاری تنبل --}}
                        <livewire:slider lazy
                            type="event"
                            title="اطلاعیه‌های مهم"
                            viewAllLink="/etelaiie"
                        />
                    </div>
                </div>
            </div>
        </main>

        <footer class="bg-gradient-to-t from-black to-gray-900 text-white py-8 mt-12">
            <div class="container mx-auto px-4">
                <x-footer/>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    @livewireScripts
</body>
</html>
