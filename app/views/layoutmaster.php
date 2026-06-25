<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($data['title']) ? htmlspecialchars($data['title']) : 'Quản Lý Sinh Viên'; ?></title>
    <!-- Link the premium styling file -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/style.css">
</head>
<body>
    <div class="layout-wrapper">
        <!-- Sidebar Navigation -->
        <?php require_once '../app/views/partials/sidebar.php'; ?>

        <!-- Main Dashboard View Area -->
        <main class="main-content">
            <!-- Header Bar -->
            <?php require_once '../app/views/partials/header.php'; ?>

            <!-- Content Area -->
            <div class="container">
                <?php
                if (isset($data['page'])) {
                    $pagePath = '../app/views/' . $data['page'] . '.php';
                    if (file_exists($pagePath)) {
                        require_once $pagePath;
                    } else {
                        echo "<div class='card alert alert-danger'>Mục nội dung <strong>" . htmlspecialchars($data['page']) . "</strong> không tồn tại!</div>";
                    }
                }
                ?>
            </div>

            <!-- Footer Bar -->
            <?php require_once '../app/views/partials/footer.php'; ?>
        </main>
    </div>
</body>
</html>
