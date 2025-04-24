<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پروفایل دانشجو - آموزشیار</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.fontcdn.ir/Font/Persian/Vazir/Vazir.css">
    <style>
        body {
            font-family: 'Vazir', sans-serif;
        }
    </style>
</head>
<body class="antialiased font-vazir">
    <div class="min-h-screen bg-gradient-to-br from-gray-900 to-black">
        <!-- هدر قبلی (لوگو دانشگاه و خروج) -->
        <header class="bg-black/30 backdrop-blur-md shadow-md sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-4">
                    <!-- لوگو دانشگاه -->
                    <div class="flex-shrink-0">
                        <img class="h-16 sm:h-16 w-auto" src="{{ asset('images/azad-logo.png') }}" alt="لوگو دانشگاه آزاد">
                    </div>

                    <!-- دکمه بازگشت به آموزشیار -->
                    <a href="{{ route('amoozeshyar') }}"
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-xl text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-900 focus:ring-gray-500 transition-colors duration-200">
                        <svg class="w-5 h-5 ml-2 rtl:mr-2 rtl:ml-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                        </svg>
                        بازگشت
                    </a>

                    <!-- دکمه خروج -->
                    <div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-xl text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-900 focus:ring-red-500 transition-colors duration-200">
                                <svg class="w-5 h-5 ml-2 rtl:mr-2 rtl:ml-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                خروج
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- محتوای اصلی با عرض بیشتر -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

            <!-- کارت اطلاعات شخصی -->
            <div class="bg-white/5 backdrop-blur-lg rounded-3xl overflow-hidden mb-10 border border-gray-700/50 shadow-xl transform transition-all hover:scale-[1.01]">
                <div class="p-6 sm:p-8">
                    <div class="flex flex-col sm:flex-row items-center space-y-5 sm:space-y-0 sm:space-x-6 rtl:sm:space-x-reverse">
                        <div class="flex-shrink-0">
                            <div class="relative group">
                                <div class="absolute -inset-1 bg-gradient-to-r from-purple-600 to-blue-500 rounded-full blur-md opacity-60 group-hover:opacity-80 transition duration-300 animate-pulse"></div>
                                <div class="relative h-20 w-20 sm:h-24 sm:w-24 rounded-full bg-gradient-to-tl from-gray-800 to-gray-900 flex items-center justify-center border-2 border-gray-600 shadow-lg">
                                    <span class="text-3xl sm:text-4xl font-bold text-white">{{ substr($data['userData']?->name ?? '?', 0, 1) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-center sm:text-right">
                            <h3 class="text-2xl sm:text-3xl font-bold text-white">
                                {{ $data['userData']?->name ?? 'نامشخص' }}
                            </h3>
                            <p class="mt-1 text-lg text-indigo-400 font-medium">
                                {{ $data['studentData']?->major ?? 'نامشخص' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- بخش اطلاعات تحصیلی با استایل جدید -->
            <div class="bg-white/5 backdrop-blur-lg rounded-3xl overflow-hidden mb-10 border border-gray-700/50 shadow-lg">
                <div class="px-6 py-5 border-b border-gray-700/50">
                    <h3 class="text-xl leading-6 font-semibold text-white">اطلاعات تحصیلی</h3>
                </div>
                <div class="px-6 py-8">
                    <dl class="grid grid-cols-1 gap-x-8 gap-y-10 sm:grid-cols-2 lg:grid-cols-5">
                        <div class="sm:col-span-1 text-center sm:text-right">
                            <dt class="text-sm font-medium text-gray-400">ترم فعلی</dt>
                            <dd class="mt-1 text-2xl font-semibold text-white">{{ $data['userStatus']?->term ?? '-' }}</dd>
                        </div>
                        <div class="sm:col-span-1 text-center sm:text-right">
                            <dt class="text-sm font-medium text-gray-400">واحدهای پاس شده</dt>
                            <dd class="mt-1 text-2xl font-semibold text-white">{{ $data['userStatus']?->passed_units ?? '-' }}</dd>
                        </div>
                        <div class="sm:col-span-1 text-center sm:text-right">
                            <dt class="text-sm font-medium text-gray-400">مقطع</dt>
                            <dd class="mt-1 text-2xl font-semibold text-white">{{ $data['studentData']?->degree_level ?? '-' }}</dd>
                        </div>
                        <div class="sm:col-span-1 text-center sm:text-right">
                            <dt class="text-sm font-medium text-gray-400">معدل ترم پیش</dt>
                            <dd class="mt-1 text-2xl font-semibold text-white">{{ $data['userGpa']?->last_gpa ?? '-' }}</dd>
                        </div>
                        <div class="sm:col-span-1 text-center sm:text-right">
                            <dt class="text-sm font-medium text-gray-400">معدل کل</dt>
                            <dd class="mt-1 text-2xl font-semibold text-white">{{ $data['userGpa']?->cumulative_gpa ?? '-' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- کامپوننت Livewire Volt برای نمایش دروس -->
            <div class="bg-transparent rounded-3xl overflow-hidden">
                 <livewire:profil :data="$data" />
            </div>

        </main>

        <footer class="bg-gradient-to-t from-black/50 to-gray-900/50 text-white py-8 mt-16 backdrop-blur-sm border-t border-gray-700/50">
            <div class="container mx-auto px-4">
                <x-footer/>
            </div>
        </footer>
    </div>
</body>
</html>
