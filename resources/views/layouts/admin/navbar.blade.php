<!-- Navbar -->
<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
  <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
    <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
      <i class="bx bx-menu bx-sm"></i>
    </a>
  </div>

  <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">    
    <ul class="navbar-nav flex-row align-items-center ms-auto">
      <!-- Notification -->
      <li class="nav-item navbar-dropdown dropdown-user dropdown me-3" id="notif">
        <a class="nav-link dropdown-toggle hide-arrow iconClass" href="javascript:void(0);" data-bs-toggle="dropdown">
          <i data-count="1" class="bx bx-bell notification-icon text-primary" style="font-size: 20pt">
            @if (auth()->guard('admin')->user()->unreadNotifications->count())
              <span class="top-0 badge rounded-pill bg-danger">{{ auth()->guard('admin')->user()->unreadNotifications->count() }}</span>
            @endif
          </i>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
          @forelse(auth()->guard('admin')->user()->unreadNotifications as $notification)
            <li>
              <div class="dropdown-item" >
                [{{ $notification->created_at }}] {{ $notification->data['nama'] }} membuat order baru!
                <a href="#" class="float-right mark-as-read" data-id="{{ $notification->id }}">
                  Mark as read
                </a>
              </div>
            </li>
            @if($loop->last)
              <li>
                <div class="dropdown-divider"></div>
              </li>
              <li>
                <a href="#" id="mark-all" class="dropdown-item">
                  <span class="align-middle text-primary">Mark All as Read</span>
                </a>
              </li>
            @endif
          @empty
            <li>
              <span class="dropdown-item align-middle text-light">There are no new notifications</span>
            </li>
          @endforelse
          <li>
            <a href="{{ route('admin.order') }}" class="dropdown-item">
              <i class="me-2 bx bx-cart-alt"></i>
              <span class="align-middle">Lihat Semua Order</span>
            </a>
          </li>
        </ul>
      </li>
      <!-- / Noification -->

      <!-- Username & Role -->
      <div class="user-name text-end me-3">
        <h6 class="mb-0 text-gray-600">
          @if (Auth::guard('admin')->check())
              {{ Auth::guard('admin')->user()->nama }}                                                
          @elseif (Auth::guard('web')->check())
              {{ Auth::guard('web')->user()->nama }}   
          @endif
        </h6>
        <p class="mb-0 text-sm text-gray-600">
          @if (Auth::guard('admin')->check())
              Administrator                                             
          @elseif (Auth::guard('web')->check())
              Operator Cabdin {{ Auth::guard('web')->user()->cabdin }}    
          @endif
        </p>
      </div>
      <!-- / Username & Role -->

      <!-- User Profil Dropdown -->
      <li class="nav-item navbar-dropdown dropdown-user dropdown">
        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
          <div class="avatar avatar-online">
            <img src="{{ asset('assets_admin/img/avatars/1.png') }}" alt class="w-px-40 h-auto rounded-circle" />
          </div>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
          <li>
            <a class="dropdown-item" href="#">
              <div class="d-flex">
                <div class="flex-shrink-0 me-3">
                  <div class="avatar avatar-online">
                    <img src="../assets_admin/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                  </div>
                </div>
                <div class="flex-grow-1">
                  <span class="fw-semibold d-block">
                    @if (Auth::guard('admin')->check())
                      {{ Auth::guard('admin')->user()->nama }}                                                
                    @elseif (Auth::guard('web')->check())
                      {{ Auth::guard('web')->user()->nama }}   
                    @endif
                  </span>
                  <small class="text-muted">
                    @if (Auth::guard('admin')->check())
                      Admin                                             
                    @elseif (Auth::guard('web')->check())
                      User   
                    @endif
                  </small>
                </div>
              </div>
            </a>
          </li>
          <li>
            <div class="dropdown-divider"></div>
          </li>
          <li>
            <a class="dropdown-item" href="#">
              <i class="bx bx-user me-2"></i>
              <span class="align-middle">My Profile</span>
            </a>
          </li>
          <li>
            <a class="dropdown-item" href="#">
              <i class="bx bx-cog me-2"></i>
              <span class="align-middle">Settings</span>
            </a>
          </li>
          <li>
            <div class="dropdown-divider"></div>
          </li>
          <li>
            <a class="dropdown-item" href="{{ route('admin.logout') }}" onclick="event.preventDefault();document.
            getElementById('logout-form').submit();">
              <i class="bx bx-power-off me-2"></i>
              <span class="align-middle">Keluar</span>
            </a>
            <form action="{{ route('admin.logout') }}" method="post" class="d-none" id="logout-form">@csrf</form>
          </li>
        </ul>
      </li>
       <!-- / User Profil Dropdown -->
    </ul>
  </div>
</nav>
<!-- / Navbar -->