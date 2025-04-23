@if($isStudent)
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
                <a href="{{ route('hazve') }}" class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-blue-500/20 rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">حذف و اضافه</h3>
                    <p class="text-gray-300 text-sm">تغییر دروس ثبت نام شده</p>
                </a>
            </div>

            <div class="group bg-white/10 backdrop-blur-lg rounded-xl p-6 hover:bg-white/20 transition-all duration-300 border border-gray-700/50">
                <a href="{{ route('account') }}" class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-green-500/20 rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">امور مالی</h3>
                    <p class="text-gray-300 text-sm">مشاهده و پرداخت شهریه</p>
                </a>
            </div>

            <div class="group bg-white/10 backdrop-blur-lg rounded-xl p-6 hover:bg-white/20 transition-all duration-300 border border-gray-700/50">
                <a href="{{ route('score') }}" class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-yellow-500/20 rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">ارزشیابی استاد</h3>
                    <p class="text-gray-300 text-sm">نظرسنجی از اساتید</p>
                </a>
            </div>
        </div>
    </div>
@elseif ($isTeacher)
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-purple-900/20 to-blue-900/20 backdrop-blur-sm border border-gray-800 shadow-2xl mb-12">
        <div class="absolute inset-0 bg-[url('/images/pattern.svg')] opacity-5"></div>
        <div class="relative grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 p-8">
            <div class="group bg-white/10 backdrop-blur-lg rounded-xl p-6 hover:bg-white/20 transition-all duration-300 border border-gray-700/50">
                <a href="{{ route('nomre') }}" class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-purple-500/20 rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">ثبت نمرات</h3>
                    <p class="text-gray-300 text-sm">ثبت نمرات در دروس ترم جاری</p>
                </a>
            </div>

            <div class="group bg-white/10 backdrop-blur-lg rounded-xl p-6 hover:bg-white/20 transition-all duration-300 border border-gray-700/50">
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-green-500/20 rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">اموراداری</h3>
                    <p class="text-gray-300 text-sm">مشاهده اموراداری</p>
                </div>
            </div>

            <div class="group bg-white/10 backdrop-blur-lg rounded-xl p-6 hover:bg-white/20 transition-all duration-300 border border-gray-700/50">
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-yellow-500/20 rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">دروس ترم بعد</h3>
                    <p class="text-gray-300 text-sm">انتخاب دروس ترم بعد</p>
                </div>
            </div>
        </div>
    </div>
@endif
