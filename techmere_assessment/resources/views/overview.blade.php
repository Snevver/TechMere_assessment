<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Overview - Film API</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gray-900 min-h-screen text-gray-100">
        <!-- Include Header -->
        @include('components.header')

        <main class="container mx-auto px-4 py-8">
            @if(request('query'))
                <div>
                    <h2 class="text-2xl font-semibold mb-6">Search Results for "{{ request('query') }}"</h2>
                    <form method="GET" action="{{ route('overview') }}" class="mb-4">
                        <input type="hidden" name="query" value="{{ request('query') }}">
                        <label for="media-type" class="text-gray-400">Filter by:</label>
                        <select id="media-type" name="media_type" onchange="this.form.submit()" class="ml-2 bg-gray-700 text-gray-200 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="all" {{ request('media_type', 'all') == 'all' ? 'selected' : '' }}>All</option>
                            <option value="movie" {{ request('media_type') == 'movie' ? 'selected' : '' }}>Movies</option>
                            <option value="tvSeries" {{ request('media_type') == 'tvSeries' ? 'selected' : '' }}>TV Shows</option>
                        </select>
                    </form>
                </div>
            @endif
            
            <!-- The search results are printed here -->
            @if(isset($movies) && count($movies) > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                    @foreach($movies as $movie)
                        <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg transition-transform hover:scale-105">
                            @if(isset($movie['primary_image']['url']))
                                <img src="{{ $movie['primary_image']['url'] }}" alt="{{ $movie['primary_title'] }}" 
                                     class="w-full h-64 object-cover">
                            @else
                                <div class="w-full h-64 bg-gray-700 flex items-center justify-center">
                                    <span class="text-gray-400">No Image Available</span>
                                </div>
                            @endif
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-100 mb-2">{{ $movie['primary_title'] }}</h3>
                                <div class="flex flex-col gap-2">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-400">{{ isset($movie['start_year']) ? $movie['start_year'] : 'Year N/A' }}</span>
                                        @if(isset($movie['rating']['aggregate_rating']))
                                            <span class="text-yellow-400">★ {{ number_format($movie['rating']['aggregate_rating'], 1) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Only show the pagination if there is more then one page ofcourse-->
                @if(isset($pagination) && $pagination['total_pages'] > 1)
                    <div class="mt-8 flex justify-center gap-4 items-center">
                        @if($pagination['current_page'] > 1)
                            <a href="{{ route('overview', [
                                    'query' => $pagination['query'], 
                                    'page' => $pagination['current_page'] - 1,
                                    'media_type' => request('media_type', 'all')
                                ]) }}" 
                               class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                                Previous
                            </a>
                        @endif

                        <span class="text-gray-400">
                            Page {{ $pagination['current_page'] }} of {{ $pagination['total_pages'] }}
                        </span>

                        @if($pagination['current_page'] < $pagination['total_pages'])
                            <a href="{{ route('overview', [
                                    'query' => $pagination['query'], 
                                    'page' => $pagination['current_page'] + 1,
                                    'media_type' => request('media_type', 'all')
                                ]) }}" 
                               class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                                Next
                            </a>
                        @endif
                    </div>
                @endif

            <!-- Fallback if API response is empty -->
            @elseif(request('query'))
                <div class="text-center py-12">
                    <p class="text-gray-400 text-lg">No movies found for "{{ request('query') }}"</p>
                    <p class="text-gray-500 mt-2">Try searching with different keywords</p>
                </div>
            @else
            <!-- if query is empty -->
                <div class="text-center py-12">
                    <p class="text-gray-400 text-lg">Use the search bar above to find movies</p>
                </div>
            @endif
        </main>
    </body>
</html>