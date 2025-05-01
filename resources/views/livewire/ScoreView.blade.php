<div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-purple-900/20 to-blue-900/20 backdrop-blur-sm border border-gray-800 shadow-2xl mb-12">
    <div class="absolute inset-0 bg-[url('/images/pattern.svg')] opacity-5"></div>
    <div class="relative p-8">
        <div class="group bg-white/10 backdrop-blur-lg rounded-xl p-6 hover:bg-white/20 transition-all duration-300 border border-gray-700/50">
            <h3 class="text-xl font-bold text-white mb-6">ارزشیابی اساتید</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-700/50">
                    <thead>
                        <tr class="text-right">
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">نام استاد</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">نمره (1 تا 10)</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">عملیات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700/50">
                        @if(lessonMaster && lessonMaster->isNotEmpty())
                            {{-- حلقه برای نمایش هر استاد --}}
                            @foreach (lessonMaster as $master)
                                <tr class="hover:bg-white/10 transition-colors duration-200" wire:key="evaluation-{{ $item['lesson_id'] }}">
                                    {{-- نمایش نام استاد، با بررسی وجود master_base --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-white">{{$master}}</td>
                                    {{-- فیلد ورودی نمره، متصل به آرایه scores با کلید lesson_id --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input
                                            type="number"
                                            wire:model.lazy="scores.{{$master}}" {{-- اتصال به آرایه scores با کلید lesson_id --}}
                                            min="1"
                                            max="10"
                                            placeholder="1-10"
                                            class="bg-white/10 border border-gray-700/50 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent w-24 disabled:opacity-50 disabled:cursor-not-allowed"
                                        >
                                    </td>
                                    {{-- دکمه ثبت نمره --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <button
                                            wire:click="saveScore({{$master}})" {{-- ارسال  به تابع saveScore --}}
                                            wire:loading.attr="disabled" {{-- غیرفعال کردن هنگام لودینگ --}}
                                            wire:target="saveScore({{$master}})" {{-- نمایش لودینگ برای همین دکمه --}}
                                        >
                                            {{-- نمایش آیکون لودینگ --}}
                                            <svg wire:loading wire:target="saveScore({{$master}})" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            ثبت
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            {{-- نمایش پیام در صورت عدم وجود داده --}}
                            <tr>
                                <td colspan="4" class="text-center px-6 py-4 text-gray-400">داده‌ای برای ارزشیابی یافت نشد</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
