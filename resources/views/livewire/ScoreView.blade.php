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
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">نام درس</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">نمره (1 تا 10)</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">عملیات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700/50">
                        {{-- بررسی وجود داده برای نمایش --}}
                        {{-- شرط کامل‌تر برای اطمینان از وجود و معتبر بودن داده‌ها --}}
                        @if(isset($data) && is_array($data) && isset($data['evaluationData']) && is_array($data['evaluationData']) && count($data['evaluationData']) > 0)
                            {{-- حلقه برای نمایش هر درس/استاد --}}
                            @foreach ($data['evaluationData'] as $item)
                                <tr class="hover:bg-white/10 transition-colors duration-200" wire:key="evaluation-{{ $item['lesson_id'] }}">
                                    {{-- نمایش نام استاد، با بررسی وجود master_base --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-white">{{ $item['master_name'] ?? 'نامشخص' }}</td>
                                    {{-- نمایش نام درس --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-white">{{ $item['lesson_name'] ?? 'نامشخص' }}</td>
                                    {{-- فیلد ورودی نمره، متصل به آرایه scores با کلید lesson_id --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input
                                            type="number"
                                            wire:model.lazy="scores.{{ $item['lesson_id'] }}" {{-- اتصال به آرایه scores با کلید lesson_id --}}
                                            min="1"
                                            max="10"
                                            placeholder="1-10"
                                            {{-- بررسی اینکه آیا کاربر قبلا نمره داده یا نه برای غیرفعال کردن --}}
                                            @php
                                                $userId = Auth::id();
                                                $studentIds = json_decode($item['master_base']?->student_id ?? '[]', true) ?? [];
                                                $hasVoted = is_array($studentIds) && in_array($userId, $studentIds);
                                            @endphp
                                            @if($hasVoted) disabled title="شما قبلاً نمره داده‌اید" @endif
                                            class="bg-white/10 border border-gray-700/50 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent w-24 disabled:opacity-50 disabled:cursor-not-allowed"
                                        >
                                        {{-- نمایش خطای اعتبارسنجی برای این فیلد خاص (اگر از اعتبارسنجی Livewire استفاده شود) --}}
                                        @error('scores.' . $item['lesson_id']) <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </td>
                                    {{-- دکمه ثبت نمره --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <button
                                            wire:click="saveScore({{ $item['lesson_id'] }})" {{-- ارسال lesson_id به تابع saveScore --}}
                                            wire:loading.attr="disabled" {{-- غیرفعال کردن هنگام لودینگ --}}
                                            wire:target="saveScore({{ $item['lesson_id'] }})" {{-- نمایش لودینگ برای همین دکمه --}}
                                            {{-- غیرفعال کردن اگر کاربر قبلا رای داده یا نمره معتبر نیست --}}
                                            @if($hasVoted)
                                                disabled
                                            @else
                                                :disabled="!scores[{{ $item['lesson_id'] }}] || scores[{{ $item['lesson_id'] }}] < 1 || scores[{{ $item['lesson_id'] }}] > 10"
                                            @endif
                                            class="bg-purple-500 hover:bg-purple-600 text-white font-bold py-2 px-4 rounded-lg transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center"
                                        >
                                            {{-- نمایش آیکون لودینگ --}}
                                            <svg wire:loading wire:target="saveScore({{ $item['lesson_id'] }})" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            {{-- تغییر متن دکمه بر اساس وضعیت رای --}}
                                            <span>{{ $hasVoted ? 'ثبت شده' : 'ثبت' }}</span>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            {{-- نمایش پیام در صورت عدم وجود داده --}}
                            <tr>
                                <td colspan="4" class="text-center px-6 py-4 text-gray-400">داده‌ای برای ارزشیابی یافت نشد یا هنوز درسی اخذ نکرده‌اید.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
