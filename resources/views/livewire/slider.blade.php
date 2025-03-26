<div class="relative">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-white">{{ $title }}</h2>
        <a href="{{ $viewAllLink }}" class="text-purple-400 hover:text-purple-300 transition-colors">
            مشاهده همه
            <svg class="inline-block w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
            </svg>
        </a>
    </div>

    <div class="relative overflow-hidden rounded-2xl">
        <!-- Slides -->
        <div class="relative">
            @foreach ($items as $index => $item)
                <div x-show="$wire.currentSlide === {{ $index }}"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform translate-x-full"
                     x-transition:enter-end="opacity-100 transform translate-x-0"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100 transform translate-x-0"
                     x-transition:leave-end="opacity-0 transform -translate-x-full"
                     class="relative">
                    <div class="aspect-w-16 aspect-h-9">
                        <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}"
                             class="object-cover w-full h-full rounded-2xl">
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/50 to-transparent rounded-2xl">
                        <div class="absolute bottom-0 left-0 right-0 p-6">
                            <h3 class="text-xl font-bold text-white mb-2">{{ $item['title'] }}</h3>
                            <p class="text-gray-300 mb-4">{{ $item['description'] }}</p>
                            <a href="{{ $item['link'] }}"
                               class="inline-flex items-center text-purple-400 hover:text-purple-300 transition-colors">
                                ادامه مطلب
                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Navigation Buttons -->
        <button wire:click="previousSlide"
                class="absolute left-4 top-1/2 -translate-y-1/2 p-2 rounded-full bg-black/50 text-white hover:bg-black/70 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
        <button wire:click="nextSlide"
                class="absolute right-4 top-1/2 -translate-y-1/2 p-2 rounded-full bg-black/50 text-white hover:bg-black/70 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>

        <!-- Dots -->
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2 space-x-reverse">
            @foreach ($items as $index => $item)
                <button wire:click="goToSlide({{ $index }})"
                        class="w-2 h-2 rounded-full transition-colors duration-300 {{ $currentSlide === $index ? 'bg-white' : 'bg-white/50 hover:bg-white/75' }}">
                </button>
            @endforeach
        </div>
    </div>
</div>
