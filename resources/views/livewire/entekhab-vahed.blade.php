<div>
    <!-- بخش اطلاعات دانشجو و محدوده واحد -->
    <!-- این بخش شامل کارت‌های نمایش اطلاعات محدوده واحد و دکمه انتخاب درس است -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- کارت نمایش محدوده واحد -->
        <div class="bg-white/10 backdrop-blur-lg rounded-xl p-6 border border-gray-700/50">
            <h3 class="text-lg font-bold text-white mb-4">محدوده مجاز واحد</h3>
            <!-- نمایش حداقل واحد مجاز -->
            <div class="flex justify-between items-center">
                <span class="text-gray-300">حداقل واحد:</span>
                <span class="text-purple-400 font-bold">{{ $minUnits }}</span>
            </div>
            <!-- نمایش حداکثر واحد مجاز -->
            <div class="flex justify-between items-center mt-2">
                <span class="text-gray-300">حداکثر واحد:</span>
                <span class="text-purple-400 font-bold">{{ $maxUnits }}</span>
            </div>
            <!-- نمایش تعداد واحدهای انتخاب شده -->
            <div class="flex justify-between items-center mt-2">
                <span class="text-gray-300">واحدهای انتخاب شده:</span>
                <span class="text-purple-400 font-bold">{{ $totalUnits }}</span>
            </div>
        </div>

        <!-- دکمه انتخاب درس جدید -->
        <div class="flex items-center justify-center">
            <button
                wire:click="$set('showLessonList', true)"
                class="px-6 py-3 bg-gradient-to-r from-purple-500 to-blue-500 text-white rounded-lg hover:from-purple-600 hover:to-blue-600 transition-all duration-200">
                انتخاب درس جدید
            </button>
        </div>
    </div>

    <!-- بخش لیست دروس انتخاب شده -->
    <!-- این بخش شامل جدول نمایش دروس انتخاب شده است -->
    <div class="bg-white/10 backdrop-blur-lg rounded-xl p-6 border border-gray-700/50">
        <h3 class="text-lg font-bold text-white mb-4">دروس انتخاب شده</h3>
        <div class="overflow-x-auto">
            @if(count($selectedLessons))
                <!-- جدول دروس انتخاب شده -->
                <table class="w-full">
                    <thead>
                        <tr class="text-right text-gray-400 border-b border-gray-700">
                            <th class="py-3 px-4">نام درس</th>
                            <th class="py-3 px-4">واحد</th>
                            <th class="py-3 px-4">استاد</th>
                            <th class="py-3 px-4">زمان</th>
                            <th class="py-3 px-4">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($selectedLessons as $lessonId)
                            @php $lesson = $lessons->firstWhere('id', $lessonId); @endphp
                            <tr class="text-right text-gray-300 border-b border-gray-700/50">
                                <td class="py-3 px-4">{{ $lesson->lesten_name }}</td>
                                <td class="py-3 px-4">{{ $lesson->unit_count }}</td>
                                <td class="py-3 px-4">{{ $lesson->lesten_master }}</td>
                                <td class="py-3 px-4">
                                    @php
                                        $schedule = json_decode($lesson->class_schedule);
                                        $days = implode('، ', $schedule->days);
                                        echo "{$days} {$schedule->time->start} - {$schedule->time->end}";
                                    @endphp
                                </td>
                                <td class="py-3 px-4">
                                    <button
                                        wire:click="toggleLesson({{ $lesson->id }})"
                                        class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors duration-200">
                                        حذف
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <!-- پیام عدم وجود درس انتخاب شده -->
                <p class="text-gray-400 text-center">هنوز درسی انتخاب نشده است</p>
            @endif
        </div>
    </div>

    <!-- دکمه ثبت نهایی -->
    <!-- این دکمه فقط در صورت وجود درس انتخاب شده نمایش داده می‌شود -->
    @if(count($selectedLessons))
        <div class="mt-6 flex justify-end">
            <button
                wire:click="submit"
                class="px-6 py-3 bg-gradient-to-r from-purple-500 to-blue-500 text-white rounded-lg hover:from-purple-600 hover:to-blue-600 transition-all duration-200">
                ثبت نهایی
            </button>
        </div>
    @endif

    <!-- مودال نمایش لیست دروس -->
    @if($showLessonList)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4">
                <!-- پس‌زمینه تار -->
                <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" wire:click="$set('showLessonList', false)"></div>

                <!-- محتوای مودال -->
                <div class="relative bg-gray-900 rounded-xl p-8 max-w-2xl w-full border border-gray-700">
                    <!-- عنوان مودال -->
                    <h3 class="text-xl font-bold text-white mb-6">درس‌های قابل برداشت</h3>

                    <!-- لیست دروس منحصر به فرد -->
                    <div class="grid grid-cols-1 gap-4 max-h-96 overflow-y-auto">
                        @foreach($uniqueLessons as $lesson)
                            @if(!in_array($lesson->id, $selectedLessons))
                                <!-- دکمه نمایش جزئیات هر درس -->
                                <div
                                    wire:click="showLessonDetails('{{ $lesson->lesten_name }}')"
                                    class="bg-white/5 p-4 rounded-lg hover:bg-white/10 transition-colors duration-200 cursor-pointer">
                                    <h3 class="text-lg font-semibold text-white">{{ $lesson->lesten_name }}</h3>
                                    <span class="text-gray-400 text-sm">({{ $lesson->unit_count }} واحد)</span>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <!-- دکمه بستن مودال -->
                    <button
                        wire:click="$set('showLessonList', false)"
                        class="absolute top-4 left-4 text-gray-400 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- مودال نمایش جزئیات درس -->
    @if($showLessonDetails)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4">
                <!-- پس‌زمینه تار -->
                <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" wire:click="$set('showLessonDetails', false)"></div>

                <!-- محتوای مودال -->
                <div class="relative bg-gray-900 rounded-xl p-8 max-w-2xl w-full border border-gray-700">
                    <!-- عنوان درس -->
                    <h3 class="text-xl font-bold text-white mb-6">{{ $selectedLessonName }}</h3>

                    <!-- اطلاعات کلی درس -->
                    <div class="space-y-4">
                        <!-- لیست کلاس‌های این درس -->
                        <div class="mt-6">
                            <h4 class="text-lg font-semibold text-white mb-4">کلاس‌های موجود:</h4>
                            <div class="space-y-4">
                                @if($selectedLessonClasses && $selectedLessonClasses->isNotEmpty())
                                    @foreach($selectedLessonClasses as $class)
                                        <div class="bg-white/5 p-4 rounded-lg">
                                            <!-- اطلاعات استاد -->
                                            <div class="flex justify-between items-center mb-2">
                                                <span class="text-gray-400">استاد:</span>
                                                <span class="text-white">{{ $class->lesten_master }}</span>
                                            </div>

                                            <!-- اطلاعات ظرفیت -->
                                            <div class="flex justify-between items-center mb-2">
                                                <span class="text-gray-400">ظرفیت:</span>
                                                <span class="text-white">{{ $class->registered_count }} / {{ $class->capacity }}</span>
                                            </div>

                                            <!-- اطلاعات زمان کلاس -->
                                            <div class="flex justify-between items-center mb-2">
                                                <span class="text-gray-400">زمان کلاس:</span>
                                                <span class="text-white">
                                                    @php
                                                        $schedule = json_decode($class->class_schedule);
                                                        $days = implode('، ', $schedule->days);
                                                        echo "{$days} {$schedule->time->start} - {$schedule->time->end}";
                                                    @endphp
                                                </span>
                                            </div>

                                            <!-- اطلاعات محل کلاس -->
                                            <div class="flex justify-between items-center">
                                                <span class="text-gray-400">کلاس:</span>
                                                <span class="text-white">{{ $class->classroom }}</span>
                                            </div>

                                            <!-- دکمه انتخاب این کلاس -->
                                            <div class="mt-4 flex justify-end">
                                                <button
                                                    wire:click="toggleLesson({{ $class->id }})"
                                                    class="px-4 py-2 bg-gradient-to-r from-purple-500 to-blue-500 text-white rounded-lg hover:from-purple-600 hover:to-blue-600 transition-all duration-200">
                                                    انتخاب این کلاس
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center text-gray-400">
                                        هیچ کلاسی برای این درس یافت نشد.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- دکمه بستن مودال -->
                    <button
                        wire:click="$set('showLessonDetails', false)"
                        class="absolute top-4 left-4 text-gray-400 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- بخش نمایش پیام‌های سیستم -->
    <!-- این بخش برای نمایش پیام‌های موفقیت و خطا استفاده می‌شود -->
    <div
        x-data="{ show: false, message: '', type: '' }"
        x-show="show"
        x-transition
        @show-message.window="
            show = true;
            message = $event.detail.message;
            type = $event.detail.type;
            setTimeout(() => show = false, 3000);
        "
        class="fixed bottom-4 right-4 p-4 rounded-lg"
        :class="{
            'bg-green-500': type === 'success',
            'bg-red-500': type === 'error'
        }">
        <span x-text="message" class="text-white"></span>
    </div>
</div>
