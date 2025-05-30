<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdn.fontcdn.ir/Font/Persian/Vazir/Vazir.css">
    <title>آزاد</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gradient-to-br from-gray-900 to-black min-h-screen font-vazir">
    <div x-data="{ isOpen: false }" class="relative">
        <!-- Header -->
        <header class="fixed top-0 left-0 right-0 z-50 bg-gradient-to-b from-black/80 to-transparent backdrop-blur-md">
            <nav class="container mx-auto px-4 py-2">
                <div class="flex items-center justify-between h-16">
                    <!-- Logo -->
                    <a href="#" class="flex items-center space-x-2 space-x-reverse">
                        <img src="{{ asset('images/azad-logo.png') }}" alt="دانشگاه آزاد" class="h-16 w-auto transform group-hover:scale-105 transition-transform duration-300">
                        <span class="text-2xl font-bold bg-gradient-to-r from-purple-400 to-blue-400 bg-clip-text text-transparent">
                            آزاد
                        </span>
                    </a>

                    <!-- Desktop Navigation -->
                    <div class="hidden md:flex items-center space-x-1 space-x-reverse">
                        <a href="https://vadamap.ec.iau.ir" target="_blank"
                           class="nav-link">آموزش مجازی وادانا</a>
                        <a href="/khabar" class="nav-link">اخبار</a>
                        <a href="/etelaiie" class="nav-link">اطلاعیه</a>
                        <a href="https://help.iau.ir/fa" target="_blank"
                           class="nav-link">مدیر آموزش</a>
                        <a href="#" class="nav-link">سیستم پشتیبانی</a>
                        <a href="#foot" class="nav-link">تماس با ما</a>
                    </div>

                    <div class="flex items-center space-x-4 space-x-reverse">
                        <!-- Login Button -->
                        <a href="/login"
                           class="hidden md:flex items-center px-6 py-2.5 rounded-xl bg-gradient-to-r from-purple-600 to-blue-500 text-white hover:from-purple-500 hover:to-blue-400 transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-purple-500/25">
                            <span>ورود به آموزشیار</span>
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                        </a>

                        <!-- Mobile Menu Button -->
                        <button @click="isOpen = !isOpen"
                                class="md:hidden p-2 rounded-lg hover:bg-gray-800/50 transition-colors">
                            <svg class="w-6 h-6 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path x-show="!isOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 6h16M4 12h16M4 18h16"/>
                                <path x-show="isOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Mobile Navigation -->
                <div x-show="isOpen"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-4"
                     class="absolute inset-x-0 top-20 p-4 bg-gray-900/95 backdrop-blur-lg rounded-2xl mx-4 shadow-2xl border border-gray-800">
                    <div class="flex flex-col space-y-4">
                        <a href="https://vadamap.ec.iau.ir" target="_blank"
                           class="mobile-nav-link">آموزش مجازی وادانا</a>
                        <a href="/khabar" class="mobile-nav-link">اخبار</a>
                        <a href="/etelaiie" class="mobile-nav-link">اطلاعیه</a>
                        <a href="https://help.iau.ir/fa" target="_blank"
                           class="mobile-nav-link">مدیر آموزش</a>
                        <a href="#" class="mobile-nav-link">سیستم پشتیبانی</a>
                        <a href="#foot" class="mobile-nav-link">تماس با ما</a>
                        <a href="/login" class="mobile-nav-link text-purple-400 flex items-center justify-between">
                            <span>ورود به آموزشیار</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </nav>
        </header>

        <!-- Main Content -->
        <main class="container mx-auto px-4 pt-24 pb-12">
            <!-- Hero Section -->
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-purple-900/20 to-blue-900/20 backdrop-blur-sm border border-gray-800 shadow-2xl mb-12">
                <div class="absolute inset-0 bg-[url('/images/pattern.svg')] opacity-5"></div>
                <div class="relative flex flex-col md:flex-row items-center justify-between p-8 md:p-12">
                    <div class="text-center md:text-right md:w-1/2 mb-8 md:mb-0">
                        <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                            <span class="bg-gradient-to-r from-purple-400 to-blue-400 bg-clip-text text-transparent">
                                دانشگاه آزاد اسلامی
                            </span>
                        </h1>
                        <p class="text-gray-300 text-lg mb-8 leading-relaxed">
                            بزرگ‌ترین دانشگاه حضوری جهان، پیشگام در آموزش و پژوهش
                        </p>
                    </div>
                    <div class="md:w-1/2">
                        <img src="{{ asset('images/azad1.jpg') }}" alt="University" class="w-full max-w-lg mx-auto">
                    </div>
                </div>
            </div>

            <!-- News Slider -->
            <div class="mb-12">
                <livewire:slider lazy
                    type="news"
                    title="آخرین اخبار"
                    viewAllLink="/khabar"
                />
            </div>

            <!-- Announcements Slider -->
            <div>
                <livewire:slider lazy
                    type="event"
                    title="اطلاعیه‌های مهم"
                    viewAllLink="/etelaiie"
                />
            </div>
        </main>

        <!-- Footer -->
        <footer id="foot">
            <x-footer />
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    @livewireScripts
</body>
</html>
