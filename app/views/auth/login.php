<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập - Hệ Thống Quản Lý Sinh Viên</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/style.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h1>STUDENT SYSTEM</h1>
                <p>Đăng nhập hệ thống quản lý sinh viên</p>
            </div>
            
            <?php if (!empty($data['error'])): ?>
                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($data['error']); ?>
                </div>
            <?php endif; ?>
            
            <form action="<?php echo BASE_URL; ?>/auth/login" method="POST">
                <div class="form-group">
                    <label class="form-label" for="username">Tên đăng nhập</label>
                    <input type="text" id="username" name="username" class="form-control" placeholder="Tài khoản mặc định: admin" required autofocus>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="password">Mật khẩu</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Mật khẩu mặc định: admin" required>
                </div>
                
                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 12px; height: 46px;">
                    Đăng Nhập
                </button>
            </form>
        </div>
    </div>
</body>
</html>
