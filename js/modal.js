let editMode = false;

// ── MODAL ──
function openModal(ticket = null) {
  editMode = !!ticket;
  document.getElementById("modal-title").textContent = editMode
    ? "Edit Ticket"
    : "New Ticket";
  document.getElementById("form-id").value = ticket?.id || "";
  document.getElementById("form-name").value = ticket?.passenger_name || "";
  document.getElementById("form-origin").value = ticket?.origin || "";
  document.getElementById("form-destination").value = ticket?.destination || "";
  document.getElementById("form-date").value = ticket?.travel_date || "";
  document.getElementById("form-seat").value = ticket?.seat_number || "";
  document.getElementById("form-price").value = ticket?.ticket_price || "";
  document.getElementById("form-status").value = ticket?.status || "active";
  document.getElementById("status-field").classList.toggle("hidden", !editMode);
  document.getElementById("form-error").classList.add("hidden");
  document.getElementById("modal").classList.remove("hidden");
}

function closeModal() {
  document.getElementById("modal").classList.add("hidden");
}
