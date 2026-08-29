<aside
  :class="sidebarToggle ? 'w-20' : 'w-[290px]'"
  class="sidebar fixed left-0 top-0 z-9999 flex h-screen transition-all duration-300 flex-col overflow-y-hidden border-r border-gray-200 bg-white px-5 dark:border-gray-800 dark:bg-black lg:static lg:translate-x-0"
  @click.outside="sidebarToggle = false"
>
  <!-- Sidebar Header -->
  <div :class="sidebarToggle ? 'justify-center' : 'justify-between'" class="sidebar-header flex items-center gap-2 pb-7 pt-8">
    <a href="{{ route('rt.dashboard') }}">
      <img class="w-8 h-8" src="/images/logo/logo-icon.svg" alt="Logo" />
      <span class="text-xl font-bold text-gray-800 dark:text-white" :class="sidebarToggle ? 'hidden' : ''">
        RT Panel
      </span>
    </a>
  </div>

  <!-- Sidebar Menu -->
  <div class="no-scrollbar flex flex-col overflow-y-auto duration-300 ease-linear">
    <nav x-data="{ selected: $persist('DashboardRT') }">
      <ul class="mb-6 flex flex-col gap-4">
        <!-- Menu Item Dashboard -->
        <li x-data="{ showTip: false }">
          <a href="{{ route('rt.dashboard') }}"
            class="menu-item group flex items-center gap-4 p-3 rounded-lg hover:bg-blue-100 transition relative {{ request()->routeIs('rt.dashboard') ? 'menu-item-active' : 'menu-item-inactive' }}"
            :class="sidebarToggle ? 'justify-center' : ''"
            @mouseenter="showTip = true" @mouseleave="showTip = false">
            <i class="fa fa-home text-xl"></i>
            <span x-show="!sidebarToggle" class="menu-item-text whitespace-nowrap">Dashboard</span>
            <span x-show="sidebarToggle && showTip" class="absolute left-full ml-2 bg-gray-800 text-white text-xs rounded px-2 py-1 shadow-lg z-50">Dashboard</span>
          </a>
        </li>
        <!-- Menu Item Data Warga -->
        <li x-data="{ showTip: false }">
          <a href="{{ route('residents.index') }}"
            class="menu-item group flex items-center gap-4 p-3 rounded-lg hover:bg-blue-100 transition relative {{ request()->routeIs('residents.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
            :class="sidebarToggle ? 'justify-center' : ''"
            @mouseenter="showTip = true" @mouseleave="showTip = false">
            <i class="fa fa-calendar text-xl"></i>
            <span x-show="!sidebarToggle" class="menu-item-text whitespace-nowrap">Data Warga</span>
            <span x-show="sidebarToggle && showTip" class="absolute left-full ml-2 bg-gray-800 text-white text-xs rounded px-2 py-1 shadow-lg z-50">Calendar</span>
          </a>
        </li>
        <!-- Menu Item Persetujuan Anggota Keluarga -->
        <li x-data="{ showTip: false }">
          <a href="{{ route('family-approvals.index') }}"
            class="menu-item group flex items-center gap-4 p-3 rounded-lg hover:bg-blue-100 transition relative {{ request()->routeIs('family-approvals.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
            :class="sidebarToggle ? 'justify-center' : ''"
            @mouseenter="showTip = true" @mouseleave="showTip = false">
            <i class="fa fa-users text-xl"></i>
            <span x-show="!sidebarToggle" class="menu-item-text whitespace-nowrap">Persetujuan Keluarga</span>
            <span x-show="sidebarToggle && showTip" class="absolute left-full ml-2 bg-gray-800 text-white text-xs rounded px-2 py-1 shadow-lg z-50">Persetujuan Keluarga</span>
          </a>
        </li>
        <li x-data="{ showTip: false }">
          <a href="{{ route('letters.index') }}"
            class="menu-item group flex items-center gap-4 p-3 rounded-lg hover:bg-blue-100 transition relative {{ request()->routeIs('letters.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
            :class="sidebarToggle ? 'justify-center' : ''"
            @mouseenter="showTip = true" @mouseleave="showTip = false">
            <i class="fa fa-envelope text-xl"></i>
            <span x-show="!sidebarToggle" class="menu-item-text whitespace-nowrap">Surat Pengantar</span>
            <span x-show="sidebarToggle && showTip" class="absolute left-full ml-2 bg-gray-800 text-white text-xs rounded px-2 py-1 shadow-lg z-50">Surat Pengantar</span>
          </a>
        </li>
        <!-- Menu Item Pengaduan -->
        <li x-data="{ showTip: false }">
          <a href="{{ url('rt/complaints')   }}"
            class="menu-item group flex items-center gap-4 p-3 rounded-lg hover:bg-blue-100 transition relative {{ request()->routeIs('complaints.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
            :class="sidebarToggle ? 'justify-center' : ''"
            @mouseenter="showTip = true" @mouseleave="showTip = false">
            <i class="fa fa-comments text-xl"></i>
            <span x-show="!sidebarToggle" class="menu-item-text whitespace-nowrap">Pengaduan Warga</span>
            <span x-show="sidebarToggle && showTip" class="absolute left-full ml-2 bg-gray-800 text-white text-xs rounded px-2 py-1 shadow-lg z-50">Pengaduan Warga</span>
          </a>
        </li>
        <li x-data="{ showTip: false }">
          <a href="{{ route('announcements.index') }}"
            class="menu-item group flex items-center gap-4 p-3 rounded-lg hover:bg-blue-100 transition relative {{ request()->routeIs('announcements.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
            :class="sidebarToggle ? 'justify-center' : ''"
            @mouseenter="showTip = true" @mouseleave="showTip = false">
            <i class="fa fa-bullhorn text-xl"></i>
            <span x-show="!sidebarToggle" class="menu-item-text whitespace-nowrap">Pengumuman</span>
            <span x-show="sidebarToggle && showTip" class="absolute left-full ml-2 bg-gray-800 text-white text-xs rounded px-2 py-1 shadow-lg z-50">Pengumuman</span>
          </a>
        </li>
        <li x-data="{ showTip: false }">
          <a href="{{ route('payments.index') }}"
            class="menu-item group flex items-center gap-4 p-3 rounded-lg hover:bg-blue-100 transition relative {{ request()->routeIs('payments.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
            :class="sidebarToggle ? 'justify-center' : ''"
            @mouseenter="showTip = true" @mouseleave="showTip = false">
            <i class="fa fa-money text-xl"></i>
            <span x-show="!sidebarToggle" class="menu-item-text whitespace-nowrap">Pembayaran</span>
            <span x-show="sidebarToggle && showTip" class="absolute left-full ml-2 bg-gray-800 text-white text-xs rounded px-2 py-1 shadow-lg z-50">Pembayaran</span>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>
