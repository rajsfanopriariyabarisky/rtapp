<aside
  :class="sidebarToggle ? 'w-20' : 'w-[290px]'"
  class="sidebar fixed left-0 top-0 z-9999 flex h-screen transition-all duration-300 flex-col overflow-y-hidden border-r border-gray-200 bg-white px-5 dark:border-gray-800 dark:bg-black lg:static lg:translate-x-0"
>
  <!-- SIDEBAR HEADER -->
  <div
    :class="sidebarToggle ? 'justify-center' : 'justify-between'"
    class="flex items-center gap-2 pt-8 sidebar-header pb-7"
  >
    <a href="{{ route('dashboard') }}">
      <img class="w-8 h-8" src="/images/logo/logo-icon.svg" alt="Logo" />
      <span class="text-xl font-bold text-gray-800 dark:text-white" :class="sidebarToggle ? 'hidden' : ''">
        Admin Panel
      </span>
    </a>
  </div>
  <!-- SIDEBAR HEADER -->

  <div class="flex flex-col overflow-y-auto duration-300 ease-linear no-scrollbar">
    <!-- Sidebar Menu -->
    <nav x-data="{selected: $persist('Dashboard')}" class="">
      <div>
        <h3 class="mb-4 text-xs uppercase leading-[20px] text-gray-400">
          <span class="menu-group-title" :class="sidebarToggle ? 'hidden' : ''">MENU</span>
        </h3>
        <ul class="flex flex-col gap-4 mb-6">
          <!-- Dashboard -->
          <li x-data="{ showTip: false }">
            <a href="{{ route('dashboard') }}"
               class="menu-item group flex items-center gap-4 p-3 rounded-lg hover:bg-blue-100 transition relative {{ request()->routeIs('dashboard') ? 'menu-item-active' : 'menu-item-inactive' }}"
               :class="sidebarToggle ? 'justify-center' : ''"
               @mouseenter="showTip = true" @mouseleave="showTip = false">
              <i class="fa fa-home text-xl"></i>
              <span x-show="!sidebarToggle" class="menu-item-text whitespace-nowrap">Dashboard</span>
              <span x-show="sidebarToggle && showTip" class="absolute left-full ml-2 bg-gray-800 text-white text-xs rounded px-2 py-1 shadow-lg z-50">Dashboard</span>
            </a>
          </li>
          
          <!-- User Management -->
          <li x-data="{ showTip: false }">
            <a href="{{ route('users.active') }}"
               class="menu-item group flex items-center gap-4 p-3 rounded-lg hover:bg-blue-100 transition relative {{ request()->routeIs('users.active') ? 'menu-item-active' : 'menu-item-inactive' }}"
               :class="sidebarToggle ? 'justify-center' : ''"
               @mouseenter="showTip = true" @mouseleave="showTip = false">
              <i class="fa fa-users text-xl"></i>
              <span x-show="!sidebarToggle" class="menu-item-text whitespace-nowrap">User Management</span>
              <span x-show="sidebarToggle && showTip" class="absolute left-full ml-2 bg-gray-800 text-white text-xs rounded px-2 py-1 shadow-lg z-50">User Management</span>
            </a>
          </li>

          <!-- Pending Users -->
          <li x-data="{ showTip: false }">
            <a href="{{ route('users.pending') }}"
               class="menu-item group flex items-center gap-4 p-3 rounded-lg hover:bg-blue-100 transition relative {{ request()->routeIs('users.pending') ? 'menu-item-active' : 'menu-item-inactive' }}"
               :class="sidebarToggle ? 'justify-center' : ''"
               @mouseenter="showTip = true" @mouseleave="showTip = false">
              <i class="fa fa-clock-o text-xl"></i>
              <span x-show="!sidebarToggle" class="menu-item-text whitespace-nowrap">Akun Pending</span>
              <span x-show="sidebarToggle && showTip" class="absolute left-full ml-2 bg-gray-800 text-white text-xs rounded px-2 py-1 shadow-lg z-50">Akun Pending</span>
            </a>
          </li>

          <!-- Export Users -->
          <li x-data="{ showTip: false }">
            <a href="{{ route('users.export.excel') }}"
               class="menu-item group flex items-center gap-4 p-3 rounded-lg hover:bg-blue-100 transition relative {{ request()->routeIs('users.export.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
               :class="sidebarToggle ? 'justify-center' : ''"
               @mouseenter="showTip = true" @mouseleave="showTip = false">
              <i class="fa fa-download text-xl"></i>
              <span x-show="!sidebarToggle" class="menu-item-text whitespace-nowrap">Export Data</span>
              <span x-show="sidebarToggle && showTip" class="absolute left-full ml-2 bg-gray-800 text-white text-xs rounded px-2 py-1 shadow-lg z-50">Export Data</span>
            </a>
          </li>

          <!-- Payment Management -->
          <li x-data="{ showTip: false }">
            <a href="{{ route('payments.index') }}"
               class="menu-item group flex items-center gap-4 p-3 rounded-lg hover:bg-blue-100 transition relative {{ request()->routeIs('payments.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
               :class="sidebarToggle ? 'justify-center' : ''"
               @mouseenter="showTip = true" @mouseleave="showTip = false">
              <i class="fa fa-credit-card text-xl"></i>
              <span x-show="!sidebarToggle" class="menu-item-text whitespace-nowrap">Manajemen Pembayaran</span>
              <span x-show="sidebarToggle && showTip" class="absolute left-full ml-2 bg-gray-800 text-white text-xs rounded px-2 py-1 shadow-lg z-50">Manajemen Pembayaran</span>
            </a>
          </li>

          <!-- Payment Report -->
          <li x-data="{ showTip: false }">
            <a href="{{ route('admin.payments.paymentReport') }}"
               class="menu-item group flex items-center gap-4 p-3 rounded-lg hover:bg-blue-100 transition relative {{ request()->routeIs('admin.payments.paymentReport') ? 'menu-item-active' : 'menu-item-inactive' }}"
               :class="sidebarToggle ? 'justify-center' : ''"
               @mouseenter="showTip = true" @mouseleave="showTip = false">
              <i class="fa fa-bar-chart text-xl"></i>
              <span x-show="!sidebarToggle" class="menu-item-text whitespace-nowrap">Laporan Pembayaran</span>
              <span x-show="sidebarToggle && showTip" class="absolute left-full ml-2 bg-gray-800 text-white text-xs rounded px-2 py-1 shadow-lg z-50">Laporan Pembayaran</span>
            </a>
          </li>
        </ul>
      </div>
    </nav>
  </div>
</aside>
