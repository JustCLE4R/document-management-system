// JavaScript untuk menampilkan toast
function createToast(type, text) {
  const notifications = document.querySelector(".notifications");
  const toast = document.createElement("li");
  toast.className = `toast ${type}`;
  toast.innerHTML = `<div class="column">
                          <i class="fa-solid ${getIcon(type)}"></i>
                          <span>${text}</span>
                      </div>
                      <i class="fa-solid fa-xmark" onclick="removeToast(this.parentElement)"></i>`;
  notifications.appendChild(toast);
  toast.timeoutId = setTimeout(() => removeToast(toast), 5000);
}

// Fungsi untuk menghapus toast
function removeToast(toast) {
  toast.classList.add("hide");
  if(toast.timeoutId) clearTimeout(toast.timeoutId);
  setTimeout(() => toast.remove(), 500);
}

// Fungsi untuk mendapatkan ikon berdasarkan tipe toast
function getIcon(type) {
  switch (type) {
    case 'success':
      return 'fa-circle-check';
    case 'error':
      return 'fa-circle-xmark';
    case 'warning':
      return 'fa-triangle-exclamation';
    case 'info':
      return 'fa-circle-info';
    default:
      return '';
  }
}