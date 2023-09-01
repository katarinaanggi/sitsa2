<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="/" class="app-brand-link">
      <span class="app-brand-text demo menu-text fw-bolder ms-2">SITSA</span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    
    <!-- Dashboard -->
    <li class="menu-item {{ ($title == 'Dashboard') ? 'active' : '' }}">
      <a href="{{ route('admin.home') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Analytics">Dashboard</div>
      </a>
    </li>

    
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Online Store</span>
    </li>
    
    <!-- User Management -->
    <li class="menu-item {{ ($title == 'User Management') ? 'active' : '' }}">
      <a href="{{ route('admin.userManagement') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-group"></i>
        <div data-i18n="Kelola Pelanggan">Kelola Pelanggan</div>
      </a>
    </li>

    <!-- Category -->
    <li class="menu-item {{ ($title == 'Category' || $title == 'Skin Care' || $title == 'Make Up' || $title == 'Body Care' || $title == 'Hair Care' || $title == 'Lainnya') ? 'open' : '' }}">
      <a href="javascript:void(0)" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-category"></i>
        <div data-i18n="Kategori Produk">Kategori Produk</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item {{ ($title == 'Category') ? 'active' : '' }}">
          <a href="{{ route('admin.category') }}" class="menu-link">
            <div data-i18n="Daftar Kategori">Daftar Kategori</div>
          </a>
        </li>
        <li class="menu-item {{ ($title == 'Skin Care') ? 'active' : '' }}">
          <a href="{{ route('admin.show_by_category', 1) }}" class="menu-link">
            <div data-i18n="Skin Care">Skin Care</div>
          </a>
        </li>
        <li class="menu-item {{ ($title == 'Make Up') ? 'active' : '' }}">
          <a href="{{ route('admin.show_by_category', 2) }}" class="menu-link">
            <div data-i18n="Make Up">Make Up</div>
          </a>
        </li>
        <li class="menu-item {{ ($title == 'Body Care') ? 'active' : '' }}">
          <a href="{{ route('admin.show_by_category', 3) }}" class="menu-link">
            <div data-i18n="Body Care">Body Care</div>
          </a>
        </li>
        <li class="menu-item {{ ($title == 'Hair Care') ? 'active' : '' }}">
          <a href="{{ route('admin.show_by_category', 4) }}" class="menu-link">
            <div data-i18n="Hair Care">Hair Care</div>
          </a>
        </li>
        <li class="menu-item {{ ($title == 'Lainnya') ? 'active' : '' }}">
          <a href="{{ route('admin.show_by_category', 5) }}" class="menu-link">
            <div data-i18n="Lainnya">Lainnya</div>
          </a>
        </li>
      </ul>
    </li>

    <li class="menu-item {{ ($title == 'Brand') ? 'active' : '' }}">
      <a href="{{ route('admin.brand') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-purchase-tag-alt"></i>
        <div data-i18n="Merek Produk">Merek Produk</div>
      </a>
    </li>

    <li class="menu-item {{ ($title == 'Product') ? 'active' : '' }}">
      <a href="{{ route('admin.product') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bxs-package"></i>
        <div data-i18n="Produk">Produk</div>
      </a>
    </li>

    <li class="menu-item {{ ($title == 'Order') ? 'active' : '' }}">
      <a href="{{ route('admin.order') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-cart-alt"></i>
        <div data-i18n="Pemesanan">Pemesanan</div>
      </a>
    </li>

    <li class="menu-item {{ ($title == 'Income' || $title == 'Expense') ? 'open' : '' }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-notepad"> </i>
        <div data-i18n="Rekap">Rekap</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item {{ ($title == 'Income') ? 'active' : '' }}">
          <a href="{{ route('admin.income') }}" class="menu-link">
            <div data-i18n="Pemasukan">Pemasukan</div>
          </a>
        </li>
        <li class="menu-item {{ ($title == 'Expense') ? 'active' : '' }}">
          <a href="{{ route('admin.expense') }}" class="menu-link">
            <div data-i18n="Pengeluaran">Pengeluaran</div>
          </a>
        </li>
      </ul>
    </li>

    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Account</span>
    </li>

    <li class="menu-item {{ ($title == 'Profil') ? 'active' : '' }}">
      <a href="{{ route('admin.profile') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-user"></i>
        <div data-i18n="Profile">Profil</div>
      </a>
    </li>

    <li class="menu-item {{ ($title == 'Keluar') ? 'active' : '' }}">
      <a class="menu-link" href="{{ route('admin.logout') }}" onclick="event.preventDefault();document.
      getElementById('logout-form').submit();">
        <i class="menu-icon tf-icons bx bx-power-off"></i>
        <div data-i18n="Log Out">Keluar</div>
      </a>
      <form action="{{ route('admin.logout') }}" method="post" class="d-none" id="logoutform">@csrf</form>
    </li>
  </ul>
</aside>
<!-- / Menu -->