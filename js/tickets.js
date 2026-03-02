// ── LOAD & RENDER ──
async function loadTickets(search = "") {
  const res = await fetch(`${API.read}?search=${encodeURIComponent(search)}`);
  const tickets = await res.json();
  renderTable(tickets);
  updateStats(tickets);
}

function renderTable(tickets) {
  const tbody = document.getElementById("ticket-table-body");
  if (!tickets.length) {
    tbody.innerHTML = `<tr><td colspan="8" class="text-center py-12 text-slate-400">No tickets found.</td></tr>`;
    return;
  }
  tbody.innerHTML = tickets
    .map(
      (t) => `
    <tr class="border-t border-slate-700 hover:bg-slate-700/40 transition-colors fade-in">
      <td class="px-5 py-4 text-slate-400">#${t.id}</td>
      <td class="px-5 py-4 font-medium text-white">${escHtml(t.passenger_name)}</td>
      <td class="px-5 py-4 text-slate-300">${escHtml(t.origin)} &rarr; ${escHtml(t.destination)}</td>
      <td class="px-5 py-4 text-slate-300">${formatDate(t.travel_date)}</td>
      <td class="px-5 py-4 text-slate-300">${escHtml(t.seat_number)}</td>
      <td class="px-5 py-4 text-amber-400 font-semibold">&#6107;${parseFloat(t.ticket_price).toLocaleString("en-US")}</td>
      <td class="px-5 py-4">
        <span class="px-2 py-1 rounded-full text-xs font-semibold ${t.status === "active" ? "bg-green-500/20 text-green-400" : "bg-red-500/20 text-red-400"}">
          ${t.status}
        </span>
      </td>
      <td class="px-5 py-4 text-center space-x-2">
        <button onclick="editTicket(${t.id})" class="bg-blue-500/20 hover:bg-blue-500/40 text-blue-400 px-3 py-1 rounded-lg text-xs font-medium transition-colors">Edit</button>
        <button onclick="deleteTicket(${t.id})" class="bg-red-500/20 hover:bg-red-500/40 text-red-400 px-3 py-1 rounded-lg text-xs font-medium transition-colors">Delete</button>
      </td>
    </tr>
  `,
    )
    .join("");
}

function updateStats(tickets) {
  document.getElementById("stat-total").textContent = tickets.length;
  document.getElementById("stat-active").textContent = tickets.filter(
    (t) => t.status === "active",
  ).length;
  document.getElementById("stat-cancelled").textContent = tickets.filter(
    (t) => t.status === "cancelled",
  ).length;
}

// ── SEARCH ──
let searchTimer;
function searchTickets(val) {
  clearTimeout(searchTimer);
  searchTimer = setTimeout(() => loadTickets(val), 300);
}

// ── CITY AUTOCOMPLETE ──
function showSuggestions(input, listId) {
  const list = document.getElementById(listId);
  const query = input.value.toLowerCase();
  const filtered = CITIES.filter((c) => c.toLowerCase().includes(query));

  if (!filtered.length || !query) {
    list.classList.add("hidden");
    return;
  }

  list.innerHTML = filtered
    .map(
      (city) => `
    <li class="px-3 py-2 text-sm text-slate-200 hover:bg-slate-600 cursor-pointer transition-colors"
      onmousedown="selectCity('${city}', '${input.id}', '${listId}')">
      ${city}
    </li>
  `,
    )
    .join("");

  list.classList.remove("hidden");
}

function hideSuggestions(listId) {
  setTimeout(
    () => document.getElementById(listId).classList.add("hidden"),
    150,
  );
}

function selectCity(city, inputId, listId) {
  document.getElementById(inputId).value = city;
  document.getElementById(listId).classList.add("hidden");
}

document.addEventListener("DOMContentLoaded", () => {
  loadTickets();
});
