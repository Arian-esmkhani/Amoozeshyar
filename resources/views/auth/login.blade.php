<x-layouts.auth>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-900 to-black py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <div class="bg-gradient-to-r from-purple-900/20 to-blue-900/20 backdrop-blur-sm border border-gray-800 shadow-2xl rounded-3xl p-8">
                <div class="text-center mb-8">
                    <img src="/images/azad-logo.png" alt="Logo" class="h-16 w-auto mx-auto mb-4">
                    <h2 class="text-3xl font-bold">
                        <span class="bg-gradient-to-r from-purple-400 to-blue-400 bg-clip-text text-transparent">
                            ورود به آموزش‌یار
                        </span>
                    </h2>
                </div>

                <form class="space-y-6" action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="username" class="sr-only">نام کاربری</label>
                            <input id="username" name="username" type="text" required
                                class="appearance-none relative block w-full px-4 py-3 border border-gray-700 bg-gray-800/50 placeholder-gray-400 text-white rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300 @error('username') border-red-500 @enderror"
                                placeholder="نام کاربری"
                                value="{{ old('username') }}"
                                autocomplete="username">
                            @error('username')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="password" class="sr-only">رمز عبور</label>
                            <input id="password" name="password" type="password" required
                                class="appearance-none relative block w-full px-4 py-3 border border-gray-700 bg-gray-800/50 placeholder-gray-400 text-white rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300 @error('password') border-red-500 @enderror"
                                placeholder="رمز عبور"
                                autocomplete="current-password">
                            @error('password')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox"
                            class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-700 rounded bg-gray-800/50">
                        <label for="remember_me" class="mr-2 block text-sm text-gray-300">
                            مرا به خاطر بسپار
                        </label>
                    </div>

                    <div>
                        <button type="submit"
                            class="group relative w-full flex justify-center px-6 py-3 rounded-xl bg-gradient-to-r from-purple-600 to-blue-500 text-white hover:from-purple-500 hover:to-blue-400 transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-purple-500/25">
                            <span class="absolute right-0 inset-y-0 flex items-center pr-3">
                                <svg class="h-5 w-5 text-purple-300 group-hover:text-purple-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            ورود به سیستم
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.auth>
