<aside
  :class="sidebarToggle ? 'w-20' : 'w-[290px]'"
  class="sidebar fixed left-0 top-0 z-9999 flex h-screen transition-all duration-300 flex-col overflow-y-hidden border-r border-gray-200 bg-white px-5 dark:border-gray-800 dark:bg-black lg:static lg:translate-x-0"
  @click.outside="sidebarToggle = false"
>
  <!-- Sidebar Header -->
  <div :class="sidebarToggle ? 'justify-center' : 'justify-between'" class="sidebar-header flex items-center gap-2 pb-7 pt-8">
    <a href="{{ route('warga.dashboard') }}">
      <img class="w-8 h-8" src="/images/logo/logo-icon.svg" alt="Logo" />
      <span class="text-xl font-bold text-gray-800 dark:text-white" :class="sidebarToggle ? 'hidden' : ''">
        Warga Panel
      </span>
    </a>
  </div>

  <!-- Sidebar Menu -->
  <div class="no-scrollbar flex flex-col overflow-y-auto duration-300 ease-linear">
    <nav x-data="{ selected: $persist('DashboardWarga') }">
      <ul class="mb-6 flex flex-col gap-4">
        <!-- Menu Item Dashboard -->
        <li x-data="{ showTip: false }">
          <a href="{{ route('warga.dashboard') }}"
            class="menu-item group flex items-center gap-4 p-3 rounded-lg hover:bg-blue-100 transition relative {{ request()->routeIs('warga.dashboard') ? 'menu-item-active' : 'menu-item-inactive' }}"
            :class="sidebarToggle ? 'justify-center' : ''"
            @mouseenter="showTip = true" @mouseleave="showTip = false">
            <i class="fa fa-home text-xl"></i>
            <span x-show="!sidebarToggle" class="menu-item-text whitespace-nowrap">Dashboard</span>
            <span x-show="sidebarToggle && showTip" class="absolute left-full ml-2 bg-gray-800 text-white text-xs rounded px-2 py-1 shadow-lg z-50">Dashboard</span>
          </a>
        </li>

        <!-- Menu Item Data Keluarga -->
        <li x-data="{ showTip: false }">
          <a href="{{ route('warga.family.index') }}"
            class="menu-item group flex items-center gap-4 p-3 rounded-lg hover:bg-blue-100 transition relative {{ request()->routeIs('warga.family.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
            :class="sidebarToggle ? 'justify-center' : ''"
            @mouseenter="showTip = true" @mouseleave="showTip = false">
            <i class="fa fa-users text-xl"></i>
            <span x-show="!sidebarToggle" class="menu-item-text whitespace-nowrap">Data Keluarga</span>
            <span x-show="sidebarToggle && showTip" class="absolute left-full ml-2 bg-gray-800 text-white text-xs rounded px-2 py-1 shadow-lg z-50">Data Keluarga</span>
          </a>
        </li>

        <!-- Menu Item Pengajuan Keluarga -->
        <li x-data="{ showTip: false }">
          <a href="{{ route('family-approvals.my-approvals') }}"
            class="menu-item group flex items-center gap-4 p-3 rounded-lg hover:bg-blue-100 transition relative {{ request()->routeIs('family-approvals.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
            :class="sidebarToggle ? 'justify-center' : ''"
            @mouseenter="showTip = true" @mouseleave="showTip = false">
            <i class="fa fa-clock-o text-xl"></i>
            <span x-show="!sidebarToggle" class="menu-item-text whitespace-nowrap">Pengajuan Keluarga</span>
            <span x-show="sidebarToggle && showTip" class="absolute left-full ml-2 bg-gray-800 text-white text-xs rounded px-2 py-1 shadow-lg z-50">Pengajuan Keluarga</span>
          </a>
        </li>

        <!-- Menu Item Surat Pengantar -->
        <li x-data="{ showTip: false }">
          <a href="{{ route('warga.letters.index') }}"
            class="menu-item group flex items-center gap-4 p-3 rounded-lg hover:bg-blue-100 transition relative {{ request()->routeIs('warga.letters.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
            :class="sidebarToggle ? 'justify-center' : ''"
            @mouseenter="showTip = true" @mouseleave="showTip = false">
            <i class="fa fa-envelope text-xl"></i>
            <span x-show="!sidebarToggle" class="menu-item-text whitespace-nowrap">Surat Pengantar</span>
            <span x-show="sidebarToggle && showTip" class="absolute left-full ml-2 bg-gray-800 text-white text-xs rounded px-2 py-1 shadow-lg z-50">Surat Pengantar</span>
          </a>
        </li>

        <!-- Menu Item Pengaduan -->
        <li x-data="{ showTip: false }">
          <a href="{{ route('complaints.index') }}"
            class="menu-item group flex items-center gap-4 p-3 rounded-lg hover:bg-blue-100 transition relative {{ request()->routeIs('warga.complaints.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
            :class="sidebarToggle ? 'justify-center' : ''"
            @mouseenter="showTip = true" @mouseleave="showTip = false">
            <i class="fa fa-comments text-xl"></i>
            <span x-show="!sidebarToggle" class="menu-item-text whitespace-nowrap">Pengaduan</span>
            <span x-show="sidebarToggle && showTip" class="absolute left-full ml-2 bg-gray-800 text-white text-xs rounded px-2 py-1 shadow-lg z-50">Pengaduan</span>
          </a>
        </li>

        <!-- Menu Item Pengumuman -->
        <li x-data="{ showTip: false }">
          <a href="{{ url('pengumuman') }}"
            class="menu-item group flex items-center gap-4 p-3 rounded-lg hover:bg-blue-100 transition relative {{ request()->routeIs('warga.announcements.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
            :class="sidebarToggle ? 'justify-center' : ''"
            @mouseenter="showTip = true" @mouseleave="showTip = false">
            <i class="fa fa-bullhorn text-xl"></i>
            <span x-show="!sidebarToggle" class="menu-item-text whitespace-nowrap">Pengumuman</span>
            <span x-show="sidebarToggle && showTip" class="absolute left-full ml-2 bg-gray-800 text-white text-xs rounded px-2 py-1 shadow-lg z-50">Pengumuman</span>
          </a>
        </li>

        <!-- Menu Item Pembayaran -->
        <li x-data="{ showTip: false }">
          <a href="{{ url('pembayaran-saya') }}"
            class="menu-item group flex items-center gap-4 p-3 rounded-lg hover:bg-blue-100 transition relative {{ request()->routeIs('warga.payments.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
            :class="sidebarToggle ? 'justify-center' : ''"
            @mouseenter="showTip = true" @mouseleave="showTip = false">
            <i class="fa fa-money text-xl"></i>
            <span x-show="!sidebarToggle" class="menu-item-text whitespace-nowrap">Pembayaran</span>
            <span x-show="sidebarToggle && showTip" class="absolute left-full ml-2 bg-gray-800 text-white text-xs rounded px-2 py-1 shadow-lg z-50">Pembayaran</span>
          </a>
        </li>

        <!-- Menu Item Profil -->
        <li x-data="{ showTip: false }">
          <a href="{{ route('warga.profile.index') }}"
            class="menu-item group flex items-center gap-4 p-3 rounded-lg hover:bg-blue-100 transition relative {{ request()->routeIs('warga.profile.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
            :class="sidebarToggle ? 'justify-center' : ''"
            @mouseenter="showTip = true" @mouseleave="showTip = false">
            <i class="fa fa-user text-xl"></i>
            <span x-show="!sidebarToggle" class="menu-item-text whitespace-nowrap">Profil Saya</span>
            <span x-show="sidebarToggle && showTip" class="absolute left-full ml-2 bg-gray-800 text-white text-xs rounded px-2 py-1 shadow-lg z-50">Profil Saya</span>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>
