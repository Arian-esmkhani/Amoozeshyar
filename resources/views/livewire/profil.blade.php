<?php

use function Livewire\Volt\{state, mount};
use Illuminate\Support\Collection;

// Define properties that the component will use
state(lessons: fn () => collect());
state(userData: null);
// Add other states if needed by the component's logic itself

// Mount hook to receive data from the parent view
mount(function (array $data) {
    $this->lessons = $data['lessons'] ?? collect();
    $this->userData = $data['userData'] ?? null;
    // Assign other data pieces if they are directly used within this component's view/logic
});

?>

<div class="bg-white/5 backdrop-blur-lg rounded-3xl overflow-hidden border border-gray-700/50 shadow-lg">
    <div class="px-6 py-5 border-b border-gray-700/50">
        <h3 class="text-xl leading-6 font-semibold text-white">دروس ترم جاری</h3>
    </div>
    <div class="px-2 sm:px-6 py-4">
        <div class="overflow-x-auto -mx-2 sm:-mx-6">
            <table class="min-w-full divide-y divide-gray-700/50">
                <thead class="bg-black/20 sticky top-0 z-10 backdrop-blur-sm">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">ID درس</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">نام درس</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">واحد</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">استاد</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">قیمت</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">زمان کلاس</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">شماره کلاس</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">زمان امتحان</th>
                    </tr>
                </thead>
                <tbody class="bg-transparent divide-y divide-gray-700/50">
                    @forelse ($this->lessons as $lesson)
                        <tr class="hover:bg-white/10 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-200">{{ $lesson->lesten_id ?? '' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $lesson->lesten_name ?? '' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $lesson->unit_count ?? '' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $lesson->lesten_master ?? '' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $lesson->lesten_price ? number_format($lesson->lesten_price) . ' ریال' : '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                @php
                                    if (!empty($lesson->class_schedule)) {
                                        try {
                                            $schedule = json_decode($lesson->class_schedule, false, 512, JSON_THROW_ON_ERROR);
                                            if ($schedule && isset($schedule->days) && isset($schedule->time->start) && isset($schedule->time->end)) {
                                                $days = implode('، ', $schedule->days);
                                                echo "{$days} <span class='font-mono text-xs text-gray-400'>{$schedule->time->start} - {$schedule->time->end}</span>";
                                            } else { echo '<span class="text-gray-500">-</span>'; }
                                        } catch (JsonException $e) {
                                             echo '<span class="text-red-500 text-xs">خطا در زمان</span>';
                                        }
                                    } else { echo '<span class="text-gray-500">-</span>'; }
                                @endphp
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $lesson->classroom ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $lesson->lesten_final ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-10 text-center text-sm text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                </svg>
                                <p class="mt-2 text-gray-400">درسی برای این ترم انتخاب نشده است.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
