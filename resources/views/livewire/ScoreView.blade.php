<?php

use function Livewire\Volt\{state, mount};

// Define state: $data will be passed in from the parent
state(['data']);

// Mount function to receive the :data parameter
mount(function ($data) {
    $this->data = $data;
});

// Placeholder for the save score action
$saveScore = function ($score) {
    // TODO: Implement logic to save the score
    // You can access the master and lesson info via $this->data
    // e.g., $masterName = $this->data['masterBase']->master_name ?? 'N/A';
    // dd('Saving score:', $score, 'for master:', $masterName);
};

?>

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
                        {{-- Displaying single row based on controller logic returning first() --}}
                        {{-- Check if masterBase exists before accessing its properties --}}
                        @if($data && isset($data['masterBase']) && isset($data['lessonName']))
                            <tr class="hover:bg-white/10 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-white">{{ $data['masterBase']->master_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-white">{{ $data['lessonName'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input
                                        type="number"
                                        wire:model="scoreValue" {{-- Added wire:model for score --}}
                                        min="1"
                                        max="10"
                                        placeholder="نمره"
                                        class="bg-white/10 border border-gray-700/50 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent w-24"
                                    >
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button
                                        wire:click="saveScore({{ $scoreValue ?? 'null' }})" {{-- Pass scoreValue to saveScore --}}
                                        class="bg-purple-500 hover:bg-purple-600 text-white font-bold py-2 px-4 rounded-lg transition-all duration-300 disabled:opacity-50"
                                        :disabled="!scoreValue || scoreValue < 1 || scoreValue > 10" {{-- Basic AlpineJS validation --}}
                                    >
                                        ثبت
                                    </button>
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td colspan="4" class="text-center px-6 py-4 text-gray-400">داده‌ای برای ارزشیابی یافت نشد.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
