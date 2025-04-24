@props(['userData'])

<nav x-data="{ isOpen: false }" class="relative">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-20">
            <!-- لوگو و نام سایت -->
            <div class="flex items-center space-x-4 space-x-reverse">
                <div class="relative group">
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-600 to-blue-500 rounded-full blur opacity-30 group-hover:opacity-70 transition duration-1000"></div>
                    <div class="relative">
                        <img src="{{ asset('images/azad-logo.png') }}" alt="دانشگاه آزاد" class="h-19 w-auto transform group-hover:scale-105 transition-transform duration-300">
                    </div>
                </div>
                <div>
                    <h1 class="text-2xl font-bold bg-gradient-to-r from-purple-400 to-blue-400 bg-clip-text text-transparent">
                        دانشگاه آزاد
                    </h1>
                </div>
            </div>

            <!-- پروفایل کاربر -->
            <div class="relative group">
                <a href="/profil" class="flex items-center space-x-3 space-x-reverse">
                    <div class="relative">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-r from-purple-500 to-blue-500 flex items-center justify-center text-white font-bold text-lg transform group-hover:scale-105 transition-transform duration-300">
                            {{ substr($userData->name, 0, 1) }}
                        </div>
                        <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-400 border-2 border-white rounded-full"></div>
                    </div>
                    <span class="text-white">{{ $userData->name }}</span>
                </a>

                <!-- منوی کشویی پروفایل -->
                <div class="hidden group-hover:block absolute left-0 mt-2 w-48 rounded-xl bg-white/10 backdrop-blur-lg border border-gray-700/50 shadow-2xl">
                    <div class="py-1">
                        <a href="/profil" class="block px-4 py-2 text-gray-300 hover:bg-white/10 transition-colors duration-200">پروفایل</a>
                    </div>
                </div>
            </div>

            <!-- دکمه بازگشت -->
            <a href="/" class="flex items-center px-4 py-2 rounded-xl bg-white/10 backdrop-blur-lg border border-gray-700/50 text-gray-300 hover:bg-white/20 transition-all duration-300 group">
                <svg class="w-5 h-5 ml-2 transform group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>بازگشت</span>
            </a>
        </div>
    </div>
</nav>

<style>
    .nav-link {
        @apply text-gray-300 hover:text-white transition-colors duration-200;
    }
</style>
