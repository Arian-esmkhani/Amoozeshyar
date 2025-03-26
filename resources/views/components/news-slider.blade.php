@props(['news'])

<div x-data="{
    activeSlide: 0,
    slides: @js($news),
    timer: null,
    init() {
        this.timer = setInterval(() => this.nextSlide(), 5000);
    },
    nextSlide() {
        this.activeSlide = (this.activeSlide + 1) % this.slides.length;
    },
    prevSlide() {
        this.activeSlide = (this.activeSlide - 1 + this.slides.length) % this.slides.length;
    }
}"
class="relative w-full overflow-hidden rounded-2xl bg-gradient-to-br from-gray-900 to-gray-800 p-1"
@mouseover="clearInterval(timer)"
@mouseleave="timer = setInterval(() => nextSlide(), 5000)">

    <!-- اسلایدر اصلی -->
    <div class="relative h-[400px] w-full">
        <template x-for="(slide, index) in slides" :key="index">
            <div x-show="activeSlide === index"
                x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 transform translate-x-full"
                x-transition:enter-end="opacity-100 transform translate-x-0"
                x-transition:leave="transition ease-in duration-500"
                x-transition:leave-start="opacity-100 transform translate-x-0"
                x-transition:leave-end="opacity-0 transform -translate-x-full"
                class="absolute inset-0">

                <div class="relative h-full w-full">
                    <img :src="slide.image" :alt="slide.title"
                        class="h-full w-full object-cover brightness-50">

                    <div class="absolute bottom-0 right-0 w-full bg-gradient-to-t from-black/80 p-6 text-right">
                        <h3 x-text="slide.title"
                            class="mb-2 text-xl font-bold text-white"></h3>
                        <p x-text="slide.description"
                            class="text-sm text-gray-200"></p>
                        <div class="mt-4">
                            <a :href="slide.link"
                                class="inline-flex items-center rounded-lg bg-purple-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-purple-700">
                                ادامه مطلب
                                <svg class="mr-2 h-4 w-4 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <!-- دکمه‌های ناوبری -->
    <div class="absolute inset-y-0 left-0 flex items-center">
        <button @click="prevSlide"
            class="group ml-4 rounded-full bg-black/30 p-2 text-white backdrop-blur-sm transition hover:bg-black/50">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
    </div>

    <div class="absolute inset-y-0 right-0 flex items-center">
        <button @click="nextSlide"
            class="group mr-4 rounded-full bg-black/30 p-2 text-white backdrop-blur-sm transition hover:bg-black/50">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
    </div>

    <!-- نشانگرهای اسلاید -->
    <div class="absolute bottom-4 left-1/2 flex -translate-x-1/2 space-x-2">
        <template x-for="(slide, index) in slides" :key="index">
            <button @click="activeSlide = index"
                :class="{'bg-white': activeSlide === index, 'bg-white/50': activeSlide !== index}"
                class="h-2 w-2 rounded-full transition-all duration-300 hover:bg-white">
            </button>
        </template>
    </div>
</div>
