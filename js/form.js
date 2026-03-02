// ── SUBMIT ──
async function submitForm() {
  const id = document.getElementById("form-id").value;
  const data = {
    id: id ? parseInt(id) : null,
    passenger_name: document.getElementById("form-name").value.trim(),
    origin: document.getElementById("form-origin").value.trim(),
    destination: document.getElementById("form-destination").value.trim(),
    travel_date: document.getElementById("form-date").value,
    seat_number: document.getElementById("form-seat").value.trim(),
    ticket_price: parseFloat(document.getElementById("form-price").value),
    status: document.getElementById("form-status").value,
  };
  if (
    !data.passenger_name ||
    !data.origin ||
    !data.destination ||
    !data.travel_date ||
    !data.seat_number ||
    isNaN(data.ticket_price)
  ) {
    showError("Please fill in all fields correctly.");
    return;
  }

  const endpoint = editMode ? API.update : API.create;
  const method = editMode ? "PUT" : "POST";
  const res = await fetch(endpoint, {
    method,
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(data),
  });
  const result = await res.json();

  if (result.error) {
    showError(result.error);
    return;
  }
  closeModal();
  showToast(result.message, "success");
  loadTickets();
}

// ── EDIT ──
async function editTicket(id) {
  const res = await fetch(`${API.read}?id=${id}`);
  const ticket = await res.json();
  if (ticket.error) {
    showToast(ticket.error, "error");
    return;
  }
  openModal(ticket);
}

// ── DELETE ──
async function deleteTicket(id) {
  if (!confirm("Delete this ticket? This cannot be undone.")) return;
  const res = await fetch(API.delete, {
    method: "DELETE",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ id }),
  });
  const result = await res.json();
  showToast(
    result.message || result.error,
    result.success ? "success" : "error",
  );
  if (result.success) loadTickets();
}
