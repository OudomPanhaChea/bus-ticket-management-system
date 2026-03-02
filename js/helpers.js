// ── HELPERS ──
function showError(msg) {
  const el = document.getElementById("form-error");
  el.textContent = msg;
  el.classList.remove("hidden");
}

function showToast(msg, type = "success") {
  const toast = document.getElementById("toast");
  toast.textContent = (type === "success" ? "✅ " : "❌ ") + msg;
  toast.className = `fixed bottom-6 right-6 z-50 border rounded-xl px-5 py-3 text-sm font-medium shadow-2xl fade-in ${type === "success" ? "bg-green-900 border-green-700 text-green-300" : "bg-red-900 border-red-700 text-red-300"}`;
  setTimeout(() => toast.classList.add("hidden"), 3000);
}

function escHtml(str) {
  const d = document.createElement("div");
  d.textContent = str;
  return d.innerHTML;
}

function formatDate(dateStr) {
  if (!dateStr) return "-";
  const d = new Date(dateStr);
  return d.toLocaleDateString("en-KH", {
    year: "numeric",
    month: "short",
    day: "numeric",
  });
}
