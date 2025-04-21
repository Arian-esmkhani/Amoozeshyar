@props(['isOnline' => true])

<div class="fixed bottom-4 right-4 z-50">
    <button
        x-data="{ isOpen: false }"
        @click="isOpen = !isOpen"
        class="relative group"
    >
        <!-- دکمه چت -->
        <div class="w-14 h-14 rounded-full bg-gradient-to-r from-purple-600 to-blue-500 flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-110">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
        </div>

        <!-- نشانگر آنلاین بودن -->
        <div class="absolute bottom-0 right-0 w-4 h-4 rounded-full {{ $isOnline ? 'bg-green-500' : 'bg-gray-500' }} border-2 border-white"></div>

        <!-- پاپ‌آپ چت -->
        <div
            x-show="isOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-95"
            class="fixed bottom-20 right-4 w-80 h-96 bg-white/10 backdrop-blur-lg rounded-2xl border border-gray-700/50 shadow-2xl overflow-hidden"
        >
            <!-- هدر چت -->
            <div class="p-4 bg-gradient-to-r from-purple-600/20 to-blue-500/20 border-b border-gray-700/50">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3 space-x-reverse">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-r from-purple-600 to-blue-500 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-bold">پشتیبانی آنلاین</h3>
                            <p class="text-gray-300 text-sm">{{ $isOnline ? 'آنلاین' : 'آفلاین' }}</p>
                        </div>
                    </div>
                    <button @click="isOpen = false" class="text-gray-400 hover:text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- بدنه چت -->
            <div class="p-4 h-[calc(100%-120px)] overflow-y-auto">
                <!-- پیام‌ها -->
                <div class="space-y-4">
                    <!-- پیام کاربر -->
                    <div class="flex justify-end">
                        <div class="max-w-[70%] bg-purple-500/20 rounded-2xl p-3 text-white">
                            سلام، چطور می‌تونم کمک‌تون کنم؟
                        </div>
                    </div>
                    <!-- پیام ادمین -->
                    <div class="flex justify-start">
                        <div class="max-w-[70%] bg-blue-500/20 rounded-2xl p-3 text-white">
                            سلام، من ادمین هستم. چطور می‌تونم کمکتون کنم؟
                        </div>
                    </div>
                </div>
            </div>

            <!-- فوتر چت -->
            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-700/50">
                <div class="flex items-center space-x-2 space-x-reverse">
                    <input
                        type="text"
                        placeholder="پیام خود را بنویسید..."
                        class="flex-1 bg-white/10 border border-gray-700/50 rounded-xl px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                    >
                    <button class="bg-gradient-to-r from-purple-600 to-blue-500 text-white p-2 rounded-xl hover:from-purple-500 hover:to-blue-400 transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </button>
</div>
