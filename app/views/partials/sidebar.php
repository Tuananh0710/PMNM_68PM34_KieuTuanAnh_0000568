<?php
$activeMenu = isset($data['active_menu']) ? $data['active_menu'] : '';
?>
<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-icon">Q</div>
        <div class="logo-text">STUDENT MANAGER</div>
    </div>
    
    <ul class="sidebar-menu">
        <li class="sidebar-item <?php echo $activeMenu === 'sinhvien' ? 'active' : ''; ?>">
            <a href="<?php echo BASE_URL; ?>/sinhvien/index">
                <!-- SVG Icon for Students -->
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                <span>Sinh Viên</span>
            </a>
        </li>
        <li class="sidebar-item <?php echo $activeMenu === 'lophoc' ? 'active' : ''; ?>">
            <a href="<?php echo BASE_URL; ?>/lophoc/index">
                <!-- SVG Icon for Classes -->
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <span>Lớp Học</span>
            </a>
        </li>
    </ul>

    <div class="sidebar-footer">
        <a href="<?php echo BASE_URL; ?>/auth/logout" class="logout-btn">
            <!-- SVG Icon for Log out -->
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
            </svg>
            <span>Đăng Xuất</span>
        </a>
    </div>
</aside>
