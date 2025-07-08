window.showModal = function(title, message, type = 'info', callback = null) {
    const overlay = document.getElementById('modal-overlay');
    const titleEl = document.getElementById('modal-title');
    const messageEl = document.getElementById('modal-message');
    const confirmBtn = document.getElementById('modal-confirm');
    const cancelBtn = document.getElementById('modal-cancel');
    
    // Set content
    titleEl.textContent = title;
    messageEl.textContent = message;
    
    // Configure buttons based on type
    if (type === 'confirm') {
        cancelBtn.classList.remove('hidden');
        confirmBtn.textContent = 'Delete';
        confirmBtn.className = 'px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors hover:cursor-pointer';
    } else if (type === 'success') {
        cancelBtn.classList.add('hidden');
        confirmBtn.textContent = 'OK';
        confirmBtn.className = 'px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors hover:cursor-pointer';
    } else if (type === 'error') {
        cancelBtn.classList.add('hidden');
        confirmBtn.textContent = 'OK';
        confirmBtn.className = 'px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors hover:cursor-pointer';
    } else {
        cancelBtn.classList.add('hidden');
        confirmBtn.textContent = 'OK';
        confirmBtn.className = 'px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors hover:cursor-pointer';
    }
    
    // Show modal
    overlay.classList.remove('hidden');
    
    // Confirm button
    confirmBtn.onclick = function() {
        hideModal();
        if (callback) callback(true);
    };
    
    // Cancel button
    cancelBtn.onclick = function() {
        hideModal();
        if (callback) callback(false);
    };
    
    // Handle overlay click
    overlay.onclick = function(e) {
        if (e.target === overlay) {
            hideModal();
            if (callback) callback(false);
        }
    };
};

window.hideModal = function() {
    const overlay = document.getElementById('modal-overlay');
    overlay.classList.add('hidden');
};

// Make the methods globally available
window.showModal = window.showModal;
window.hideModal = window.hideModal;