<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پروفایل دانشجو</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div x-data="{ isOpen: false }" class="min-h-screen">
        <!-- هدر -->
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-4">
                    <!-- لوگو دانشگاه -->
                    <div class="flex-shrink-0">
                        <img class="h-12 w-auto" src="{{ asset('images/university-logo.png') }}" alt="لوگو دانشگاه">
                    </div>

                    <!-- دکمه خروج -->
                    <div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                خروج
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- محتوای اصلی -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- کارت اطلاعات شخصی -->
            <div class="bg-white shadow rounded-lg overflow-hidden mb-8">
                <div class="px-4 py-5 sm:px-6">
                    <div class="flex items-center space-x-4 rtl:space-x-reverse">
                        <div class="flex-shrink-0">
                            <div class="h-16 w-16 rounded-full bg-gray-200 flex items-center justify-center">
                                <span class="text-2xl text-gray-500">{{ substr($data['userData'], 0, 1) }}</span>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                {{ $data['userData'] }}
                            </h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                {{ $data['studentData']->major }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- جدول اطلاعات تحصیلی -->
            <div class="bg-white shadow rounded-lg overflow-hidden mb-8">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">اطلاعات تحصیلی</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">ترم فعلی</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">واحدهای پاس شده</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">مقطع</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">معدل ترم پیش</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">معدل کل</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $data['userStatus']->term }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $data['userStatus']->passed_units }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $data['studentData']->degree_level }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $data['userGpa']->last_gpa }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $data['userGpa']->cumulative_gpa }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- کامپوننت Livewire -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <livewire:profil :data="$data"/>
            </div>
        </main>
    </div>
</body>
</html>
