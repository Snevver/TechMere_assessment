<header class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo/Title -->
            <div class="flex items-center">
                <h1 class="text-xl font-bold text-gray-900 dark:text-white">
                    🎬 TechMere Assessment
                </h1>
            </div>

            <!-- User menu -->
            <div class="flex items-center space-x-4">
                @auth
                    <span class="text-sm text-gray-700 dark:text-gray-300">
                        Hello, {{ Auth::user()->name }}
                    </span>
                    <form method="POST" action="{{ route('logout.post') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                            Logout
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </div>
</header>
