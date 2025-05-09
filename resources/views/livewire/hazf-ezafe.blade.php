<div>
    <!-- بخش نمایش پیام‌های سیستم از سشن -->
    @if (session()->has('message'))
        <div class="mb-6">
            <div class="fixed top-4 left-[65%] -translate-x-[45%] p-4 rounded-lg text-center z-[9999] font-bold shadow-lg   {{ session('type') === 'error' ? 'bg-red-500/10 text-red-400 border border-red-500/20' : 'bg-green-500/10 text-green-400 border border-green-500/20' }}">
                <span>{{ session('message') }}</span>
            </div>
        </div>
    @endif

    <!-- بخش لیست دروس انتخاب شده -->
    <!-- این بخش شامل جدول نمایش دروس انتخاب شده است -->
    <div class="bg-white/10 backdrop-blur-lg rounded-xl p-6 border border-gray-700/50 mb-8">
        <h3 class="text-lg font-bold text-white mb-4">دروس انتخاب شده</h3>
        <div class="overflow-x-auto">
            @if($selectedLessons && $selectedLessons->isNotEmpty())
                <!-- جدول دروس انتخاب شده -->
                <table class="w-full">
                    <thead>
                        <tr class="text-right text-gray-400 border-b border-gray-700">
                            <th class="py-3 px-5">نام درس</th>
                            <th class="py-3 px-5">کد درس</th>
                            <th class="py-3 px-5">واحد</th>
                            <th class="py-3 px-5">کلاس</th>
                            <th class="py-3 px-5">استاد</th>
                            <th class="py-3 px-5">زمان</th>
                            <th class="py-3 px-5">حذف</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($selectedLessons as $lesson)
                        <tr class="border-b border-gray-700/50 hover:bg-gray-700/20">
                            <td class="py-3 px-5 text-white">{{ $lesson->lesten_name }}</td>
                            <td class="py-3 px-5 text-white">{{ $lesson->lesten_id }}</td>
                            <td class="py-3 px-5 text-white">{{ $lesson->unit_count }}</td>
                            <td class="py-3 px-5 text-white">{{ $lesson->classroom}}</td>
                            <td class="py-3 px-5 text-white">{{ $lesson->lesten_master }}</td>
                            <td class="py-3 px-5 text-white">
                                @php
                                    $schedule = json_decode($lesson->class_schedule);
                                    $days = $schedule->days ?? [];
                                    $time = $schedule->time ?? null;
                                @endphp
                                {{ implode('، ', $days) }} <br> {{ $time ? $time->start . ' - ' . $time->end : '' }}
                            </td>
                            <td class="py-3 px-5">
                                <button wire:click="hazf({{ $lesson->lesten_id }})" wire:loading.attr="disabled"
                                        class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded-md text-sm transition-colors duration-200">
                                    <svg wire:loading wire:target="hazf({{ $lesson->lesten_id }})" class="animate-spin h-4 w-4 text-white inline-block mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    حذف
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <!-- پیام عدم وجود درس انتخاب شده -->
                <p class="text-center text-gray-400 py-4">هنوز درسی انتخاب نکرده‌اید.</p>
            @endif
        </div>
         <!-- دکمه ثبت نهایی (نمایش داده می شود اگر درسی وجود داشته باشد) -->
         @if($selectedLessons && $selectedLessons->isNotEmpty())
            <div class="mt-6 flex justify-center">
            <button
                    wire:click="submit" wire:loading.attr="disabled"
                    class="px-6 py-3 bg-gradient-to-r from-purple-500 to-blue-500 text-white rounded-lg hover:from-purple-600 hover:to-blue-600 transition-all duration-200 disabled:opacity-50">
                    <svg wire:loading wire:target="submit" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    ثبت نهایی تغییرات
            </button>
        </div>
    @endif
    </div>


    <!-- بخش اطلاعات دانشجو و محدوده واحد -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- کارت نمایش محدوده واحد -->
        <div class="bg-white/10 backdrop-blur-lg rounded-xl p-6 border border-gray-700/50">
            <h3 class="text-lg font-bold text-white mb-4">محدوده مجاز واحد</h3>
            <div class="flex justify-between items-center">
                <span class="text-gray-300">حداقل واحد:</span>
                <span class="text-purple-400 font-bold">{{ $minUnits }}</span>
            </div>
            <div class="flex justify-between items-center mt-2">
                <span class="text-gray-300">حداکثر واحد:</span>
                <span class="text-purple-400 font-bold">{{ $maxUnits }}</span>
            </div>
            <div class="flex justify-between items-center mt-2">
                <span class="text-gray-300">واحدهای انتخاب شده:</span>
                <span class="text-purple-400 font-bold">{{ $totalUnits }}</span>
            </div>
        </div>

        <!-- دکمه انتخاب درس جدید -->
        <div class="bg-white/10 backdrop-blur-lg rounded-xl p-6 border border-gray-700/50 flex items-center justify-center">
            <button
                wire:click="$set('showLessonList', true)"
                class="w-full md:w-auto px-6 py-3 bg-gradient-to-r from-purple-500 to-blue-500 text-white rounded-lg hover:from-purple-600 hover:to-blue-600 transition-all duration-200">
                افزودن / جستجوی درس جدید
            </button>
        </div>
    </div>

    <!-- مودال نمایش لیست دروس قابل انتخاب -->
    @if($showLessonList)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" wire:click="$set('showLessonList', false)"></div>
                <div class="relative bg-gray-900 rounded-xl p-8 max-w-3xl w-full border border-gray-700 max-h-[80vh] flex flex-col">
                    <h3 class="text-xl font-bold text-white mb-6 flex-shrink-0">درس‌های قابل انتخاب</h3>
                    <div class="overflow-y-auto flex-grow pr-2">
                        @if ($uniqueLessons && $uniqueLessons->isNotEmpty())
                        @foreach($uniqueLessons as $lesson)
                                @if(!in_array($lesson->lesten_id, $takeListen))
                                    <button
                                        type="button"
                                        x-on:click="$dispatch('show-lesson-details', { lessonName: '{{ $lesson->lesten_name }}' })"
                                        class="w-full text-right bg-white/5 p-4 rounded-lg hover:bg-white/10 transition-colors duration-200 cursor-pointer mb-3">
                                    <h3 class="text-lg font-semibold text-white">{{ $lesson->lesten_name }}</h3>
                                    <span class="text-gray-400 text-sm">({{ $lesson->unit_count }} واحد)</span>
                                    </button>
                            @endif
                        @endforeach
                        @else
                             <p class="text-center text-gray-400 py-4">درسی برای انتخاب یافت نشد یا تمام دروس قابل انتخاب، قبلا انتخاب شده‌اند.</p>
                        @endif
                    </div>
                    <button wire:click="$set('showLessonList', false)" class="absolute top-4 left-4 text-gray-400 hover:text-white flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- مودال نمایش جزئیات درس برای افزودن -->
    @if($showLessonDetails)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-black/20 backdrop-blur-sm" wire:click="$set('showLessonDetails', false)"></div>
                <div class="relative bg-gray-900 rounded-xl p-8 max-w-3xl w-full border border-gray-700 max-h-[80vh] flex flex-col">
                    <h3 class="text-xl font-bold text-white mb-6 flex-shrink-0">{{ $lessonName }}</h3>
                    <div class="overflow-y-auto flex-grow pr-2">
                        @if($lessonSelected && count($lessonSelected) > 0)
                                    @foreach($lessonSelected as $selected)
                                <div class="bg-white/5 p-4 rounded-lg mb-4">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-2 mb-4">
                                        <div><span class="text-gray-400">استاد:</span> <span class="text-white">{{ $selected->lesten_master }}</span></div>
                                        <div><span class="text-gray-400">گروه:</span> <span class="text-white">{{ $selected->group_number ?? '-' }}</span></div>
                                        <div><span class="text-gray-400">واحد:</span> <span class="text-white">{{ $selected->unit_count}}</span></div>
                                        <div><span class="text-gray-400">ظرفیت:</span> <span class="text-white">{{ $selected->capacity }} (ثبت‌نام شده: {{ $selected->registered_count }})</span></div>
                                        <div><span class="text-gray-400">زمان کلاس:</span>
                                                <span class="text-white">
                                                    @php
                                                        $schedule = json_decode($selected->class_schedule);
                                                    $days = $schedule->days ?? []; $time = $schedule->time ?? null;
                                                    @endphp
                                                {{ implode('، ', $days) }} {{ $time ? ($time->start . ' - ' . $time->end) : '' }}
                                                </span>
                                            </div>
                                        <div><span class="text-gray-400">مکان کلاس:</span> <span class="text-white">{{ $schedule->location ?? 'نامشخص' }}</span></div>
                                        <div><span class="text-gray-400">زمان امتحان:</span> <span class="text-white">{{ $selected->lesten_final ?? 'نامشخص' }}</span></div>
                                        <div><span class="text-gray-400">قیمت:</span> <span class="text-white">{{ number_format($selected->lesten_price ?? 0) }}</span></div>
                                            </div>

                                            <div class="mt-4 flex justify-end">
                                        @php
                                             $canAdd = true;
                                             $message = '';
                                             if ($selected->capacity <= $selected->registered_count) {
                                                 $canAdd = false; $message = 'ظرفیت تکمیل';
                                             }
                                             elseif (($totalUnits + $selected->unit_count) > $maxUnits) {
                                                  $canAdd = false; $message = 'عبور از سقف واحد';
                                             }
                                             else {
                                                 $schedule = json_decode($selected->class_schedule);
                                                 if ($schedule && isset($schedule->days) && isset($schedule->time)) {
                                                     $days = implode('، ', $schedule->days);
                                                     $timeRange = $schedule->time->start . ' - ' . $schedule->time->end;
                                                     $scheduleStringToCheck = $days . ' ' . $timeRange;
                                                     foreach ($classSchedules as $existingSchedule) {
                                                          $existingDayTime = substr($existingSchedule, strpos($existingSchedule, ' ') + 1);
                                                          if ($existingDayTime === $scheduleStringToCheck) {
                                                              $canAdd = false; $message = 'تداخل زمانی'; break;
                                                          }
                                                     }
                                                 }
                                             }
                                        @endphp

                                        @if ($canAdd)
                                            <button wire:click="actionLesson({{ $selected->lesten_id }})" wire:loading.attr="disabled" wire:target="actionLesson({{ $selected->lesten_id }})"
                                                class="px-4 py-2 bg-gradient-to-r from-purple-500 to-blue-500 text-white rounded-lg hover:from-purple-600 hover:to-blue-600 transition-all duration-200 disabled:opacity-50">
                                                <svg wire:loading wire:target="actionLesson({{ $selected->lesten_id }})" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                                افزودن این کلاس
                                                </button>
                                        @else
                                            <span class="px-4 py-2 text-sm text-yellow-400">{{ $message }}</span>
                                        @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                            <div class="text-center text-gray-400">هیچ کلاسی برای این درس یافت نشد.</div>
                                @endif
                    </div>
                    <button wire:click="$set('showLessonDetails', false)" class="absolute top-4 left-4 text-gray-400 hover:text-white flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
