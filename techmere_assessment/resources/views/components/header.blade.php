<header class="bg-gray-800 shadow-sm border-b border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo/Title -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="text-xl font-bold text-gray-300 hover:text-gray-100">
                    🎬 TechMere Assessment
                </a>
            </div>

            <!-- Search bar for movies using the TMDB API -->
            <div class="flex-grow max-w-md">
                <form method="GET" action="{{ route('myList') }}" class="flex items-center space-x-2">
                    <input 
                            type="text" 
                            name="query" 
                            placeholder="Search for movies..." 
                            class="w-full px-4 py-2 border border-gray-600 
                            rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 
                            bg-gray-700 text-gray-200">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 hover:cursor-pointer">
                        Search
                    </button>
                </form>
            </div>

            <!-- User menu -->
            <div class="flex items-center space-x-4">
                @auth
                    <form method="GET" action="{{ route('myList') }}" class="inline">
                        <button type="submit" class="text-sm text-blue-400 hover:text-blue-300 hover:cursor-pointer">
                            My List
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout.post') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm text-red-400 hover:text-red-300 hover:cursor-pointer">
                            Logout
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </div>
</header>
