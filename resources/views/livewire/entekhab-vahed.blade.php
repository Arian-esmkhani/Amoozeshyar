<div>
    <!-- بخش نمایش پیام‌های سیستم -->
    @if (session()->has('message'))
        <div class="mb-6">
            <div class="p-4 rounded-lg text-center {{ session('type') === 'error' ? 'bg-red-500/10 text-red-400 border border-red-500/20' : 'bg-green-500/10 text-green-400 border border-green-500/20' }}">
                <span>{{ session('message') }}</span>
            </div>
        </div>
    @endif

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
            @if(count($selectedLesson))
                <!-- جدول دروس انتخاب شده -->
                <table class="w-full">
                    <thead>
                        <tr class="text-right text-gray-400 border-b border-gray-700">
                            <th class="py-3 px-5">نام درس</th>
                            <th class="py-3 px-5">واحد</th>
                            <th class="py-3 px-5">استاد</th>
                            <th class="py-3 px-5">زمان</th>
                            <th class="py-3 px-5">کلاس</th>
                            <th class="py-3 px-5">حذف</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($selectedLesson as $lessonId)
                            @php
                                // Find the lesson object. Handle case where lesson might not be found in current $lessons collection.
                                $lesson = $lessons->firstWhere('id', $lessonId);
                            @endphp
                            @if($lesson)
                                <tr class="text-right text-gray-300 border-b border-gray-700/50">
                                    <td class="py-3 px-5">{{ $lesson->lesten_name }}</td>
                                    <td class="py-3 px-5">{{ $lesson->unit_count }}</td>
                                    <td class="py-3 px-5">{{ $lesson->lesten_master }}</td>
                                    <td class="py-3 px-5">
                                        @php
                                            // Safely decode JSON and display schedule
                                            try {
                                                $schedule = json_decode($lesson->class_schedule, false, 512, JSON_THROW_ON_ERROR);
                                                if (isset($schedule->days) && isset($schedule->time->start) && isset($schedule->time->end)) {
                                                    $days = implode('، ', (array)$schedule->days);
                                                    echo "{$days} {$schedule->time->start} - {$schedule->time->end}";
                                                } else {
                                                    echo 'نامشخص';
                                                }
                                            } catch (\JsonException $e) {
                                                echo 'خطا در زمان';
                                            }
                                        @endphp
                                    </td>
                                    <td class="py-3 px-5">{{ $lesson->classroom }}</td>
                                    <td class="py-3 px-5">
                                        <button
                                            wire:click="actionLesson({{ $lesson->id }})"
                                            class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors duration-200">
                                            حذف
                                        </button>
                                    </td>
                                </tr>
                            @endif
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
    @if(count($selectedLesson))
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
                            @if(!in_array($lesson->id, $selectedLesson))
                                <!-- دکمه نمایش جزئیات هر درس -->
                                <button
                                    type="button"
                                    x-on:click="$dispatch('show-lesson-details', { lessonName: '{{ $lesson->lesten_name }}' })"
                                    class="w-full text-right bg-white/5 p-4 rounded-lg hover:bg-white/10 transition-colors duration-200 cursor-pointer">
                                    <h3 class="text-lg font-semibold text-white">{{ $lesson->lesten_name }}</h3>
                                    <span class="text-gray-400 text-sm">({{ $lesson->unit_count }} واحد)</span>
                                </button>
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
                    <h3 class="text-xl font-bold text-white mb-6">{{ $lessonName }}</h3>

                    <!-- اطلاعات کلی درس -->
                    <div class="space-y-4">
                        <!-- لیست کلاس‌های این درس -->
                        <div class="mt-6">
                            <h4 class="text-lg font-semibold text-white mb-4">کلاس‌های موجود:</h4>
                            <div class="space-y-4">
                                @if($lessonSelected)
                                    @foreach($lessonSelected as $selected)
                                        <div class="bg-white/5 p-4 rounded-lg">
                                            <!-- اطلاعات استاد -->
                                            <div class="flex justify-between items-center mb-2">
                                                <span class="text-gray-400">استاد:</span>
                                                <span class="text-white">{{ $selected->lesten_master }}</span>
                                            </div>

                                            <!-- اطلاعات تعداد واحد -->
                                            <div class="flex justify-between items-center">
                                                <span class="text-gray-400">تعداد واحد:</span>
                                                <span class="text-white">{{ $selected->unit_count}}</span>
                                            </div>

                                            <!-- اطلاعات ظرفیت -->
                                            <div class="flex justify-between items-center mb-2">
                                                <span class="text-gray-400">ظرفیت:</span>
                                                <span class="text-white">{{ $selected->capacity }} - {{ $selected->registered_count }}</span>
                                            </div>

                                            <!-- اطلاعات شروع -->
                                            <div class="flex justify-between items-center mb-2">
                                                <span class="text-gray-400">شروع:</span>
                                                <span class="text-white">{{ $selected->lesten_date }}</span>
                                            </div>

                                            <!-- اطلاعات زمان کلاس -->
                                            <div class="flex justify-between items-center mb-2">
                                                <span class="text-gray-400">زمان کلاس:</span>
                                                <span class="text-white">
                                                    @php
                                                        $schedule = json_decode($selected->class_schedule);
                                                        $days = implode('، ', $schedule->days);
                                                        echo "{$days} {$schedule->time->start} - {$schedule->time->end}";
                                                    @endphp
                                                </span>
                                            </div>

                                            <!-- اطلاعات محل کلاس -->
                                            <div class="flex justify-between items-center">
                                                <span class="text-gray-400">کلاس:</span>
                                                <span class="text-white">{{ $selected->classroom }}</span>
                                            </div>

                                            <!-- اطلاعات امتحان -->
                                            <div class="flex justify-between items-center">
                                                <span class="text-gray-400">امتحان:</span>
                                                <span class="text-white">{{ $selected->lesten_final}}</span>
                                            </div>

                                            <!-- اطلاعات قیمت -->
                                            <div class="flex justify-between items-center">
                                                <span class="text-gray-400">قیمت:</span>
                                                <span class="text-white">{{ $selected->lesten_price}}</span>
                                            </div>

                                            <!-- دکمه انتخاب  -->
                                            <div class="mt-4 flex justify-end">
                                                <button
                                                    wire:click="actionLesson({{ $selected->id }})"
                                                    class="px-4 py-2 bg-gradient-to-r from-purple-500 to-blue-500 text-white rounded-lg hover:from-purple-600 hover:to-blue-600 transition-all duration-200">
                                                    انتخاب
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
</div>
