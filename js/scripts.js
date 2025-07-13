let userIdToDelete = null;

function showDeleteModal(userId) {
    userIdToDelete = userId;
    document.getElementById('confirmModal').classList.remove('hidden');
}

function closeModal() {
    userIdToDelete = null;
    document.getElementById('confirmModal').classList.add('hidden');
}

function confirmUserDelete() {
    if (userIdToDelete !== null) {
        window.location.href = 'delete_user.php?id=' + userIdToDelete;
    }
}
