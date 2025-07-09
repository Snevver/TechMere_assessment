<!-- Edit Movie Modal -->
<div id="edit-modal-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div id="edit-modal-container" class="bg-gray-800 rounded-lg shadow-xl max-w-2xl w-full mx-4 border border-gray-700">
        <!-- Modal Header -->
        <div class="px-6 py-4 border-b border-gray-700">
            <h3 class="text-lg font-semibold text-gray-100">Edit Movie</h3>
        </div>
        
        <!-- Modal Body -->
        <div class="px-6 py-4 max-h-[70vh] overflow-y-auto">
            <div class="space-y-4">
                <!-- Title -->
                <div>
                    <label for="edit-title" class="block text-sm font-medium text-gray-300 mb-2">Movie Title</label>
                    <input type="text" id="edit-title" required placeholder="Enter movie title" class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-100">
                </div>

                <!-- Description -->
                <div>
                    <label for="edit-description" class="block text-sm font-medium text-gray-300 mb-2">Description</label>
                    <textarea id="edit-description" rows="3" placeholder="Enter movie description" class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-100"></textarea>
                </div>

                <!-- Year -->
                <div>
                    <label for="edit-year" class="block text-sm font-medium text-gray-300 mb-2">Year</label>
                    <input type="number" id="edit-year" min="1900" max="2030" placeholder="e.g. 2023" class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-100">
                </div>

                <!-- Genres -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Genres</label>
                    <div id="edit-genres-container" class="grid grid-cols-2 gap-2 max-h-50 overflow-y-auto">
                        <!-- Genres will be populated here -->
                    </div>
                </div>

                <!-- Watched Status -->
                <div>
                    <label for="edit-watched" class="inline-flex items-center text-sm font-medium text-gray-300">
                        <input type="checkbox" id="edit-watched" class="mr-2 rounded bg-gray-700 border-gray-600 text-blue-600 focus:ring-blue-500">
                        Watched
                    </label>
                </div>

                <!-- Rating -->
                <div>
                    <label for="edit-rating" class="block text-sm font-medium text-gray-300 mb-2">Rating</label>
                    <input type="number" id="edit-rating" min="1" max="5" placeholder="1-5" class="w-16 px-2 py-1 bg-gray-700 border border-gray-600 rounded-lg text-gray-100">
                </div>
            </div>
        </div>
        
        <!-- Modal Footer -->
        <div class="px-6 py-4 border-t border-gray-700 flex gap-3 justify-end">
            <button id="edit-cancel" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors hover:cursor-pointer">Cancel</button>
            <button id="edit-save" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors hover:cursor-pointer">Save Changes</button>
        </div>
    </div>
</div>

@vite(['resources/js/editModal.js'])
