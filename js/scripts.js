let userIdToDelete = null;

function showDeleteModal(userId) {
  userIdToDelete = userId;
  document.getElementById("confirmModal").classList.remove("hidden");
}

function closeModal() {
  userIdToDelete = null;
  document.getElementById("confirmModal").classList.add("hidden");
}

function confirmUserDelete() {
  if (userIdToDelete !== null) {
    window.location.href = "delete_user.php?id=" + userIdToDelete;
  }
}

let taskIdToDelete = null;

function showDeleteTaskModal(taskId) {
  taskIdToDelete = taskId;
  document.getElementById("deleteTaskModal").classList.remove("hidden");
}

function closeTaskModal() {
  taskIdToDelete = null;
  document.getElementById("deleteTaskModal").classList.add("hidden");
}

function confirmTaskDelete() {
  if (taskIdToDelete !== null) {
    window.location.href = "delete_task.php?id=" + taskIdToDelete;
  }
}
