<?php
$fullname = $_SESSION['user']['fullname'] ?? 'Admin';
$username = $_SESSION['user']['username'] ?? 'admin';
$initial = strtoupper(substr($fullname, 0, 1));
?>
<header class="top-header">
    <div class="page-title">
        <?php echo isset($data['title']) ? htmlspecialchars($data['title']) : 'Quản Lý Hệ Thống'; ?>
    </div>
    
    <div class="user-profile">
        <div class="user-info">
            <div class="user-name"><?php echo htmlspecialchars($fullname); ?></div>
            <div class="user-role">@<?php echo htmlspecialchars($username); ?></div>
        </div>
        <div class="avatar">
            <?php echo htmlspecialchars($initial); ?>
        </div>
    </div>
</header>
