<div class="relative"
     {{-- حذف منطق Autoplay از Alpine --}}
     x-data="{ activeSlide: @entangle('currentSlide') }"
     {{-- اضافه کردن wire:poll و mouse events برای کنترل Autoplay Livewire --}}
     wire:poll.5000ms="autoplayTick"
     @mouseenter="$wire.pauseAutoplay()"
     @mouseleave="$wire.resumeAutoplay()">

    {{-- هدر اسلایدر --}}
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-white">{{ $title }}</h2>
        {{-- لینک "مشاهده همه" --}}
        <div wire:loading.remove>
            @if($itemCount > 0)
                <a href="{{ $viewAllLink }}"
                   class="text-purple-400 hover:text-purple-300 transition-colors text-sm font-medium flex items-center">
            مشاهده همه
                    <svg class="inline-block w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
            </svg>
        </a>
            @endif
        </div>
    </div>

    {{-- حالت انتظار (Loading State) با انیمیشن محو شدن --}}
    <div wire:loading wire:loading.class="opacity-100" wire:loading.remove.class="opacity-0 hidden"
         class="absolute inset-0 flex items-center justify-center bg-gray-900/70 rounded-2xl text-gray-300 z-20 opacity-0 transition-opacity duration-300">
        <svg class="animate-spin h-8 w-8 text-purple-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span class="ml-3 text-lg">در حال بارگذاری...</span>
    </div>

    {{-- محتوای اصلی اسلایدر --}}
    <div wire:loading.remove>
        @if($itemCount > 0)
            {{-- محفظه اصلی با دکمه های چپ/راست --}}
        <div class="relative">
                {{-- محفظه اسلایدها با overflow-hidden --}}
                <div class="relative h-[400px] md:h-[350px] overflow-hidden rounded-2xl bg-gradient-to-br from-gray-800/50 to-gray-900/70 backdrop-blur-md border border-gray-700/50 shadow-xl">
            @foreach ($items as $index => $item)
                        @if ($currentSlide === $index)
                            <div wire:key="slide-{{ $type }}-{{ $item['id'] ?? $index }}"
                                 class="h-full w-full">
                                <div class="h-full flex flex-col md:flex-row">
                                     {{-- بخش تصویر با گوشه‌های گرد --}}
                                     <div class="w-full md:w-1/2 h-1/2 md:h-full overflow-hidden md:rounded-r-2xl">
                                        <img src="{{ $item['image_url'] ?? asset('images/placeholder.png') }}"
                                             alt="{{ $item['title'] }}"
                                             class="w-full h-full object-cover">
                    </div>
                                    {{-- بخش محتوا با استایل بهتر --}}
                                    <div class="w-full md:w-1/2 p-6 md:p-8 flex flex-col justify-center bg-gradient-to-t md:bg-gradient-to-l from-gray-900/80 via-gray-900/60 to-transparent">
                                        <h3 class="text-xl lg:text-2xl font-semibold text-white mb-3 leading-tight">{{ $item['title'] }}</h3>
                                        <p class="text-gray-300 text-sm lg:text-base mb-5 line-clamp-3 md:line-clamp-4">{{ $item['description'] }}</p>
                                        @if(!empty($item['link']))
                            <a href="{{ $item['link'] }}"
                                               class="inline-flex items-center self-start text-purple-400 hover:text-purple-300 font-medium transition-colors mt-auto text-sm">
                                ادامه مطلب
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </a>
                                        @endif
                        </div>
                    </div>
                </div>
                        @endif
            @endforeach
        </div>

                {{-- دکمه‌های ناوبری چپ/راست --}}
                @if($itemCount > 1)
                    {{-- دکمه قبلی --}}
                    <button wire:click="previousSlide" aria-label="اسلاید قبلی"
                            class="absolute left-3 top-1/2 -translate-y-1/2 p-2.5 rounded-full bg-black/40 text-white hover:bg-black/60 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-50 transition-all duration-300 z-10">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </button>
                    {{-- دکمه بعدی --}}
                    <button wire:click="nextSlide" aria-label="اسلاید بعدی"
                            class="absolute right-3 top-1/2 -translate-y-1/2 p-2.5 rounded-full bg-black/40 text-white hover:bg-black/60 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-50 transition-all duration-300 z-10">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </button>
                @endif
            </div>

            {{-- نقاط ناوبری (خارج از محفظه اصلی اسلایدر) --}}
            @if($itemCount > 1)
                <div class="flex justify-center items-center space-x-3 mt-4 z-10">
            @foreach ($items as $index => $item)
                <button wire:click="goToSlide({{ $index }})"
                                aria-label="رفتن به اسلاید {{ $index + 1 }}"
                                class="flex-shrink-0 rounded-full transition-all duration-300 ease-in-out focus:outline-none
                                       {{ $currentSlide === $index
                                          ? 'w-5 h-2.5 bg-purple-500'
                                          : 'w-2.5 h-2.5 bg-gray-500/60 hover:bg-gray-400/60' }}">
                </button>
            @endforeach
        </div>
            @endif
        @else
            {{-- پیغام عدم وجود آیتم --}}
            <div class="text-center text-gray-500 bg-gray-800/60 rounded-2xl p-10 h-[400px] md:h-[350px] flex items-center justify-center">
                موردی برای نمایش وجود ندارد.
            </div>
        @endif
    </div>
</div>
