<div class="sidebar sidebar-style-2" data-background-color="dark">
    <div class="sidebar-logo">
        <div class="logo-header" style="border-bottom: 1px solid #938e8e21;" data-background-color="dark">
            <a href="#" class="logo">
                <img src="{{ asset('assets/img/logo.png') }}" alt="navbar brand" class="navbar-brand" height="28" />
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}">
                        <i class="fas fa-home"></i>
                        <p>Trang chủ</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                      <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Chữ ký điện tử</h4>
                </li>
                <li class="nav-item {{ request()->routeIs('formsManagement') ? 'active' : '' }}">
                    <a href="{{ route('formsManagement') }}">
                        <i class="fas fa-folder"></i>
                        <p>Quản lý hồ sơ</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('leaveForms','jobRequestForm') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#sidebarLayouts" aria-expanded="false" class="collapsed">
                      <i class="fas fa-th-list"></i>
                      <p>Tạo phiếu</p>
                      <span class="caret"></span>
                    </a>
                    <div class="collapse {{ request()->routeIs('leaveForms','jobRequestForm') ? 'show' : '' }}" id="sidebarLayouts">
                        <ul class="nav nav-collapse">
                            <li class="{{ request()->routeIs('leaveForms') ? 'active' : '' }}">
                                <a href="{{ route('leaveForms') }}">
                                    <span class="sub-item">Giấy xin phép</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="sub-item">Phiếu tăng ca</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('jobRequestForm') ? 'active' : '' }}">
                                <a href="{{ route('jobRequestForm') }}">
                                    <span class="sub-item">Phiếu Y/C công việc</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="sub-item">Phiếu Y/C thử nghiệm</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
