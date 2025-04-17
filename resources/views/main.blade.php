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
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-purple-900/20 to-blue-900/20 backdrop-blur-sm border border-gray-800 shadow-2xl mb-12">
                <div class="absolute inset-0 bg-[url('/images/pattern.svg')] opacity-5"></div>
                <div class="relative grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 p-8">
                    <div class="group bg-white/10 backdrop-blur-lg rounded-xl p-6 hover:bg-white/20 transition-all duration-300 border border-gray-700/50">
                        <a href="{{ route('entekhab-vahed') }}" class="flex flex-col items-center text-center">
                            <div class="w-16 h-16 bg-purple-500/20 rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-white mb-2">انتخاب واحد</h3>
                            <p class="text-gray-300 text-sm">ثبت نام در دروس ترم جاری</p>
                        </a>
                    </div>

                    <div class="group bg-white/10 backdrop-blur-lg rounded-xl p-6 hover:bg-white/20 transition-all duration-300 border border-gray-700/50">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-16 h-16 bg-blue-500/20 rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-white mb-2">حذف و اضافه</h3>
                            <p class="text-gray-300 text-sm">تغییر دروس ثبت نام شده</p>
                        </div>
                    </div>

                    <div class="group bg-white/10 backdrop-blur-lg rounded-xl p-6 hover:bg-white/20 transition-all duration-300 border border-gray-700/50">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-16 h-16 bg-green-500/20 rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-white mb-2">امور مالی</h3>
                            <p class="text-gray-300 text-sm">مشاهده و پرداخت شهریه</p>
                        </div>
                    </div>

                    <div class="group bg-white/10 backdrop-blur-lg rounded-xl p-6 hover:bg-white/20 transition-all duration-300 border border-gray-700/50">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-16 h-16 bg-yellow-500/20 rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-white mb-2">ارزشیابی استاد</h3>
                            <p class="text-gray-300 text-sm">نظرسنجی از اساتید</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-purple-900/20 to-blue-900/20 backdrop-blur-sm border border-gray-800 shadow-2xl p-6">
                    <div class="absolute inset-0 bg-[url('/images/pattern.svg')] opacity-5"></div>
                    <div class="relative">
                        <h2 class="text-xl font-bold text-white mb-4 bg-gradient-to-r from-purple-400 to-blue-400 bg-clip-text text-transparent">خبرها</h2>
                        <x-slider type="khabar" title="خبرها" viewAllLink="/khabar" :items="[
                            [
                                'image' => 'https://via.placeholder.com/150',
                                'title' => 'خبر یک',
                                'description' => 'این خبر به صورت متنی و جذاب در اینجا قرار میگیرد',
                                'link' => '/khabar/1'
                            ],
                            [
                                'image' => 'https://via.placeholder.com/150',
                                'title' => 'خبر دو',
                                'description' => 'این خبر به صورت متنی و جذاب در اینجا قرار میگیرد',
                                'link' => '/khabar/2'
                            ],
                            [
                                'image' => 'https://via.placeholder.com/150',
                                'title' => 'خبر سه',
                                'description' => 'این خبر به صورت متنی و جذاب در اینجا قرار میگیرد',
                                'link' => '/khabar/3'
                            ]
                        ]" />
                    </div>
                </div>

                <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-purple-900/20 to-blue-900/20 backdrop-blur-sm border border-gray-800 shadow-2xl p-6">
                    <div class="absolute inset-0 bg-[url('/images/pattern.svg')] opacity-5"></div>
                    <div class="relative">
                        <h2 class="text-xl font-bold text-white mb-4 bg-gradient-to-r from-purple-400 to-blue-400 bg-clip-text text-transparent">اطلاعیه‌ها</h2>
                        <x-slider type="etelaiie" title="اطلاعیه ها" viewAllLink="/etelaiie" :items="[
                            [
                                'image' => 'https://via.placeholder.com/150',
                                'title' => 'اطلاعیه یک',
                                'description' => 'این اطلاعیه به صورت متنی و جذاب در اینجا قرار میگیرد',
                                'link' => '/etelaiie/1'
                            ],
                            [
                                'image' => 'https://via.placeholder.com/150',
                                'title' => 'اطلاعیه دو',
                                'description' => 'این اطلاعیه به صورت متنی و جذاب در اینجا قرار میگیرد',
                                'link' => '/etelaiie/2'
                            ],
                            [
                                'image' => 'https://via.placeholder.com/150',
                                'title' => 'اطلاعیه سه',
                                'description' => 'این اطلاعیه به صورت متنی و جذاب در اینجا قرار میگیرد',
                                'link' => '/etelaiie/3'
                            ]
                        ]" />
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
