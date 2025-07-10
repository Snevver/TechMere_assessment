<!-- Modal Overlay -->
<div id="modal-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <!-- Modal Container -->
    <div id="modal-container" class="bg-gray-800 rounded-lg shadow-xl max-w-md w-full mx-4 border border-gray-700">
        <!-- Modal Header -->
        <div id="modal-header" class="px-6 py-4 border-b border-gray-700">
            <h3 id="modal-title" class="text-lg font-semibold text-gray-100"></h3>
        </div>
        
        <!-- Modal Body -->
        <div id="modal-body" class="px-6 py-4">
            <p id="modal-message" class="text-gray-300"></p>
        </div>
        
        <!-- Modal Footer -->
        <div id="modal-footer" class="px-6 py-4 border-t border-gray-700 flex gap-3 justify-end">
            <button id="modal-cancel" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors hover:cursor-pointer hidden">
                Cancel
            </button>
            <button id="modal-confirm" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors hover:cursor-pointer">
                OK
            </button>
        </div>
    </div>
</div>

@vite(['resources/js/app.js'])
