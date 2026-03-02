<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bus Ticket Management System</title>
  <!-- tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- google fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <!-- style.css -->
  <link rel="stylesheet" href="css/style.css">
</head>

<body class="bg-slate-900 min-h-screen text-slate-100">

  <!-- Header -->
  <header class="bg-slate-800 border-b border-slate-700 shadow-lg">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <!-- <div class="w-10 h-10 bg-amber-500 rounded-xl flex items-center justify-center text-xl">🚌</div> -->
        <div>
          <h1 class="text-xl font-bold text-white">OudomPanha's Bus Booking</h1>
          <p class="text-xs text-slate-400">Ticket Management System</p>
        </div>
      </div>
    </div>
  </header>

  <!-- Stats Bar -->
  <div class="max-w-7xl mx-auto px-6 py-5">
    <div class="grid grid-cols-3 gap-4 mb-6">
      <div class="bg-slate-800 rounded-xl p-4 border border-slate-700">
        <p class="text-xs text-slate-400 mb-1">Total Tickets</p>
        <p id="stat-total" class="text-2xl font-bold text-white">0</p>
      </div>
      <div class="bg-slate-800 rounded-xl p-4 border border-slate-700">
        <p class="text-xs text-slate-400 mb-1">Active</p>
        <p id="stat-active" class="text-2xl font-bold text-green-400">0</p>
      </div>
      <div class="bg-slate-800 rounded-xl p-4 border border-slate-700">
        <p class="text-xs text-slate-400 mb-1">Cancelled</p>
        <p id="stat-cancelled" class="text-2xl font-bold text-red-400">0</p>
      </div>
    </div>

    <!-- Search -->
    <div class="w-full flex items-center gap-4 mb-5">
      <input id="search-input" type="text" placeholder="🔍  Search by passenger, origin, or destination..."
        class="w-full bg-slate-800 border border-slate-600 text-slate-100 placeholder-slate-400 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-amber-500 transition-colors"
        oninput="searchTickets(this.value)" />
      <button onclick="openModal()"
        class="bg-amber-500 text-nowrap hover:bg-amber-400 text-slate-900 font-semibold px-4 py-3 rounded-lg text-sm transition-all flex items-center gap-2">
        <span>+</span> New Ticket
      </button>
    </div>

    <!-- Table -->
    <div class="bg-slate-800 rounded-2xl border border-slate-700 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead>
            <tr class="bg-slate-700/50 text-slate-300 text-left">
              <th class="px-5 py-4 font-semibold">ID</th>
              <th class="px-5 py-4 font-semibold">Passenger</th>
              <th class="px-5 py-4 font-semibold">Route</th>
              <th class="px-5 py-4 font-semibold">Travel Date</th>
              <th class="px-5 py-4 font-semibold">Seat</th>
              <th class="px-5 py-4 font-semibold">Price</th>
              <th class="px-5 py-4 font-semibold">Status</th>
              <th class="px-5 py-4 font-semibold text-center">Actions</th>
            </tr>
          </thead>
          <tbody id="ticket-table-body">
            <tr>
              <td colspan="8" class="text-center py-12 text-slate-400">Loading tickets...</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div id="modal" class="hidden fixed inset-0 bg-black/60 modal-overlay z-50 flex items-center justify-center px-4">
    <div class="bg-slate-800 rounded-2xl border border-slate-600 w-full max-w-md shadow-2xl fade-in">
      <div class="flex items-center justify-between px-6 py-5 border-b border-slate-700">
        <h2 id="modal-title" class="text-lg font-bold text-white">New Ticket</h2>
        <button onclick="closeModal()" class="text-slate-400 hover:text-white text-2xl leading-none">&times;</button>
      </div>
      <div class="px-6 py-5 space-y-4">
        <input type="hidden" id="form-id" />
        <div>
          <label class="block text-xs text-slate-400 mb-1">Passenger Name</label>
          <input id="form-name" type="text"
            class="w-full bg-slate-700 border border-slate-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-amber-500 text-white"
            placeholder="e.g. Oudom Panha" />
        </div>
        <div class="grid grid-cols-2 gap-3">
          <div>
            <label class="block text-xs text-slate-400 mb-1">Origin</label>
            <div class="relative">
              <input id="form-origin" type="text" autocomplete="off"
                class="w-full bg-slate-700 border border-slate-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-amber-500 text-white"
                placeholder="Search city..." oninput="showSuggestions(this, 'origin-list')"
                onblur="hideSuggestions('origin-list')" />
              <ul id="origin-list"
                class="hidden absolute z-50 w-full bg-slate-700 border border-slate-600 rounded-lg mt-1 max-h-48 overflow-y-auto shadow-xl">
              </ul>
            </div>
          </div>
          <div>
            <label class="block text-xs text-slate-400 mb-1">Destination</label>
            <div class="relative">
              <input id="form-destination" type="text" autocomplete="off"
                class="w-full bg-slate-700 border border-slate-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-amber-500 text-white"
                placeholder="Search city..." oninput="showSuggestions(this, 'destination-list')"
                onblur="hideSuggestions('destination-list')" />
              <ul id="destination-list"
                class="hidden absolute z-50 w-full bg-slate-700 border border-slate-600 rounded-lg mt-1 max-h-48 overflow-y-auto shadow-xl">
              </ul>
            </div>
          </div>
        </div>
        <div class="grid grid-cols-2 gap-3">
          <div>
            <label class="block text-xs text-slate-400 mb-1">Travel Date</label>
            <input id="form-date" type="date"
              class="w-full bg-slate-700 border border-slate-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-amber-500 text-white" />
          </div>
          <div>
            <label class="block text-xs text-slate-400 mb-1">Seat Number</label>
            <input id="form-seat" type="text"
              class="w-full bg-slate-700 border border-slate-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-amber-500 text-white"
              placeholder="e.g. A1" />
          </div>
        </div>
        <div class="grid grid-cols-2 gap-3">
          <div>
            <label class="block text-xs text-slate-400 mb-1">Price (៛ KHR)</label>
            <input id="form-price" type="number" step="1" min="0"
              class="w-full bg-slate-700 border border-slate-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-amber-500 text-white"
              placeholder="e.g. 15000" />
          </div>
          <div id="status-field" class="hidden">
            <label class="block text-xs text-slate-400 mb-1">Status</label>
            <select id="form-status"
              class="w-full bg-slate-700 border border-slate-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-amber-500 text-white">
              <option value="active">Active</option>
              <option value="cancelled">Cancelled</option>
            </select>
          </div>
        </div>
        <p id="form-error" class="text-red-400 text-xs hidden"></p>
      </div>
      <div class="px-6 pb-5 flex gap-3">
        <button onclick="closeModal()"
          class="flex-1 bg-slate-700 hover:bg-slate-600 text-slate-300 rounded-lg py-2 text-sm font-medium transition-colors">Cancel
        </button>
        <button onclick="submitForm()"
          class="flex-1 bg-amber-500 hover:bg-amber-400 text-slate-900 rounded-lg py-2 text-sm font-bold transition-colors">
          Save Ticket
        </button>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="border-t border-slate-700 mt-8">
    <div class="max-w-7xl mx-auto px-6 py-5 flex flex-col sm:flex-row items-center justify-between gap-2">
      <div class="flex items-center gap-2 text-slate-400 text-sm">
        <span><span class="text-white font-semibold">Bus Booking</span> | Bus Ticket Management System by Chea
          Oudompanha</span>
      </div>
      <p class="text-slate-500 text-xs">© 2026 All rights reserved.</p>
    </div>
  </footer>

  <!-- Toast Notification -->
  <div id="toast"
    class="hidden fixed bottom-6 right-6 z-50 bg-slate-700 border border-slate-600 rounded-xl px-5 py-3 text-sm font-medium shadow-2xl fade-in">
  </div>

  <script src="./js/config.js"></script>
  <script src="./js/helpers.js"></script>
  <script src="./js/modal.js"></script>
  <script src="./js/form.js"></script>
  <script src="./js/tickets.js"></script>
</body>

</html>