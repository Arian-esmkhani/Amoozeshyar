@props(['type', 'title', 'viewAllLink', 'items'])

<div class="relative" x-data="{
    currentIndex: 0,
    items: @js($items),
    autoplayInterval: null,
    startAutoplay() {
        this.autoplayInterval = setInterval(() => {
            this.nextSlide();
        }, 5000);
    },
    stopAutoplay() {
        clearInterval(this.autoplayInterval);
    },
    nextSlide() {
        this.currentIndex = (this.currentIndex + 1) % this.items.length;
    },
    prevSlide() {
        this.currentIndex = (this.currentIndex - 1 + this.items.length) % this.items.length;
    }
}"
x-init="startAutoplay"
@mouseenter="stopAutoplay"
@mouseleave="startAutoplay">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-white">{{ $title }}</h2>
        <a href="{{ $viewAllLink }}" class="text-purple-400 hover:text-purple-300 transition-colors">
            مشاهده همه
        </a>
    </div>

    <!-- Slider Container -->
    <div class="relative overflow-hidden rounded-xl bg-black/30 backdrop-blur-lg">
        <!-- Slides -->
        <div class="relative h-[400px]">
            <template x-for="(item, index) in items" :key="index">
                <div class="absolute inset-0 transition-all duration-500 ease-in-out transform"
                     :class="{
                         'translate-x-0 opacity-100': currentIndex === index,
                         'translate-x-full opacity-0': currentIndex < index,
                         '-translate-x-full opacity-0': currentIndex > index
                     }">
                    <div class="h-full flex flex-col md:flex-row">
                        <!-- Image Section -->
                        <div class="w-full md:w-1/2 h-1/2 md:h-full">
                            <img :src="item.image"
                                 :alt="item.title"
                                 class="w-full h-full object-cover">
                        </div>

                        <!-- Content Section -->
                        <div class="w-full md:w-1/2 p-6 flex flex-col justify-center">
                            <h3 class="text-xl font-bold text-white mb-4" x-text="item.title"></h3>
                            <p class="text-gray-300 mb-6" x-text="item.description"></p>
                            <a :href="item.link"
                               class="inline-block bg-purple-900 text-white px-6 py-2 rounded-lg hover:bg-purple-800 transition-colors">
                                ادامه مطلب
                            </a>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- Navigation Buttons -->
        <button @click="prevSlide"
                class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/50 text-white p-3 rounded-full hover:bg-black/70 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>

        <button @click="nextSlide"
                class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/50 text-white p-3 rounded-full hover:bg-black/70 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>

        <!-- Dots Navigation -->
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2 space-x-reverse">
            <template x-for="(item, index) in items" :key="index">
                <button @click="currentIndex = index"
                        class="w-2 h-2 rounded-full transition-all duration-300"
                        :class="currentIndex === index ? 'bg-purple-500 w-4' : 'bg-gray-500'">
                </button>
            </template>
        </div>
    </div>
</div>
