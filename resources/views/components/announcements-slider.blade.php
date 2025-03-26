@props(['announcements'])

<div x-data="{
    activeSlide: 0,
    slides: @js($announcements),
    timer: null,
    init() {
        this.timer = setInterval(() => this.nextSlide(), 4000);
    },
    nextSlide() {
        this.activeSlide = (this.activeSlide + 1) % this.slides.length;
    },
    prevSlide() {
        this.activeSlide = (this.activeSlide - 1 + this.slides.length) % this.slides.length;
    }
}"
class="relative w-full overflow-hidden rounded-2xl bg-gradient-to-br from-indigo-900 to-purple-900 p-1"
@mouseover="clearInterval(timer)"
@mouseleave="timer = setInterval(() => nextSlide(), 4000)">

    <!-- اسلایدر اصلی -->
    <div class="relative h-[300px] w-full">
        <template x-for="(slide, index) in slides" :key="index">
            <div x-show="activeSlide === index"
                x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 transform -translate-y-full"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-500"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform translate-y-full"
                class="absolute inset-0">

                <div class="flex h-full w-full flex-col items-center justify-center p-6 text-center">
                    <div class="mb-4 rounded-full bg-purple-500/20 p-3">
                        <svg class="h-6 w-6 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                    </div>

                    <span x-text="slide.date"
                        class="mb-2 inline-block rounded-full bg-purple-500/10 px-3 py-1 text-sm text-purple-200">
                    </span>

                    <h3 x-text="slide.title"
                        class="mb-4 text-xl font-bold text-white"></h3>

                    <p x-text="slide.description"
                        class="mb-6 max-w-lg text-sm text-gray-300"></p>

                    <a :href="slide.link"
                        class="inline-flex items-center rounded-lg bg-purple-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-purple-700">
                        مشاهده جزئیات
                        <svg class="mr-2 h-4 w-4 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </template>
    </div>

    <!-- دکمه‌های ناوبری -->
    <div class="absolute inset-y-0 left-0 flex items-center">
        <button @click="prevSlide"
            class="group ml-4 rounded-full bg-white/5 p-2 text-white backdrop-blur-sm transition hover:bg-white/20">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
    </div>

    <div class="absolute inset-y-0 right-0 flex items-center">
        <button @click="nextSlide"
            class="group mr-4 rounded-full bg-white/5 p-2 text-white backdrop-blur-sm transition hover:bg-white/20">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
    </div>

    <!-- نشانگرهای اسلاید -->
    <div class="absolute bottom-4 left-1/2 flex -translate-x-1/2 space-x-1.5">
        <template x-for="(slide, index) in slides" :key="index">
            <button @click="activeSlide = index"
                :class="{'bg-purple-500': activeSlide === index, 'bg-purple-500/30': activeSlide !== index}"
                class="h-1.5 w-6 rounded-full transition-all duration-300 hover:bg-purple-500">
            </button>
        </template>
    </div>
</div>
