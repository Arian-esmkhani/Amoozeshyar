<div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-purple-900/20 to-blue-900/20 backdrop-blur-sm border border-gray-800 shadow-2xl mb-12">
    <div class="absolute inset-0 bg-[url('/images/pattern.svg')] opacity-5"></div>
    <div class="relative p-8">
        <div class="group bg-white/10 backdrop-blur-lg rounded-xl p-6 hover:bg-white/20 transition-all duration-300 border border-gray-700/50">
            <h3 class="text-xl font-bold text-white mb-6">ارزشیابی دانشجو</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-700/50">
                    <thead>
                        <tr class="text-right">
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">نام درس</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">نام دانشجو</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">نمره (1 تا 20)</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">وضعیت</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700/50">
                        @foreach($lessonStatus as $lesson)
                            <tr class="hover:bg-white/10 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-white">{{ $lesson->lesson_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-white">{{ $lesson->student_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input
                                        type="number"
                                        x-data="{ score: '' }"
                                        x-model="score"
                                        x-bind:min="1"
                                        x-bind:max="20"
                                        placeholder="نمره را وارد کنید"
                                        class="bg-white/10 border border-gray-700/50 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent w-24"
                                    >
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-white">{{ $lesson->lesson_status }}</td>
                                <td>
                                    <button @click="$wire.saveNomre(score, '{{ $lesson->student_name }}', {{ $lesson->lesson_name }})" class="bg-purple-500 hover:bg-purple-600 text-white font-bold py-2 px-4 rounded-lg transition-all duration-300">ثبت</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div>
                    <button @click="$wire.saveScore(score)" class="bg-purple-500 hover:bg-purple-600 text-white font-bold py-2 px-4 rounded-lg transition-all duration-300">ثبت</button>
                </div>
            </div>
        </div>
    </div>
</div>