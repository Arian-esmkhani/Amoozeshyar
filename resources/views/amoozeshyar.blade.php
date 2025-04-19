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
            <livewire:mainC :userRole="$userRole"/>

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
