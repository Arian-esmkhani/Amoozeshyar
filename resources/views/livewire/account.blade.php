<div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-purple-900/20 to-blue-900/20 backdrop-blur-sm border border-gray-800 shadow-2xl mb-12">
    <div class="absolute inset-0 bg-[url('/images/pattern.svg')] opacity-5"></div>
    <div class="relative p-8">
        <!-- بخش واریز وجه -->
        <div class="mb-8">
            <div class="group bg-white/10 backdrop-blur-lg rounded-xl p-6 hover:bg-white/20 transition-all duration-300 border border-gray-700/50">
                <h3 class="text-xl font-bold text-white mb-4">واریز وجه</h3>
                <div class="flex flex-col space-y-4">
                    <input
                        type="number"
                        wire:model="amount"
                        placeholder="مبلغ واریزی را وارد کنید"
                        class="bg-white/10 border border-gray-700/50 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                    >
                    <button
                        class="bg-purple-500 hover:bg-purple-600 text-white font-bold py-2 px-4 rounded-lg transition-all duration-300"
                    >
                        واریز
                    </button>
                </div>
            </div>
        </div>

        <!-- جدول اطلاعات حساب -->
        <div class="group bg-white/10 backdrop-blur-lg rounded-xl p-6 hover:bg-white/20 transition-all duration-300 border border-gray-700/50">
            <h3 class="text-xl font-bold text-white mb-4">اطلاعات حساب</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-700/50">
                    <thead>
                        <tr class="text-right">
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">نام</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">وضعیت</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">بدهی</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">موجودی</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">تفاوت</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700/50">
                        <tr class="hover:bg-white/10 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-white">{{$data['userData']->name}}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-white">{{$data['userAccount']->payment_status}}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-white">{{$data['userAccount']->debt}}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-white">{{$data['userAccount']->credit}}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-white">{{$data['userAccount']->balance}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>