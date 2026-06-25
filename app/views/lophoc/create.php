<?php
$error = $data['error'] ?? '';
?>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; border-bottom: 1.5px solid var(--border-color); padding-bottom: 12px;">
        <h2 style="font-weight: 700; font-size: 20px; color: var(--text-primary);">Thêm Lớp Học Mới</h2>
        <a href="<?php echo BASE_URL; ?>/lophoc/index" class="btn btn-secondary btn-sm">Quay lại</a>
    </div>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form action="<?php echo BASE_URL; ?>/lophoc/create" method="POST">
        <div class="form-group">
            <label class="form-label" for="malop">Mã lớp học <span style="color: var(--danger);">*</span></label>
            <input type="text" id="malop" name="malop" class="form-control" placeholder="Ví dụ: 68PM34" required autofocus>
            <small style="color: var(--text-secondary); display: block; margin-top: 4px;">Mã lớp học là duy nhất và không được trùng lặp.</small>
        </div>

        <div class="form-group">
            <label class="form-label" for="tenlop">Tên lớp học <span style="color: var(--danger);">*</span></label>
            <input type="text" id="tenlop" name="tenlop" class="form-control" placeholder="Ví dụ: Công nghệ thông tin K68 Lớp 34" required>
        </div>

        <div style="display: flex; gap: 12px; margin-top: 24px; justify-content: flex-end;">
            <a href="<?php echo BASE_URL; ?>/lophoc/index" class="btn btn-secondary">Hủy bỏ</a>
            <button type="submit" class="btn btn-primary">Lưu lại</button>
        </div>
    </form>
</div>
