<?php
$classes = $data['classes'] ?? [];
$error = $data['error'] ?? '';
?>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; border-bottom: 1.5px solid var(--border-color); padding-bottom: 12px;">
        <h2 style="font-weight: 700; font-size: 20px; color: var(--text-primary);">Thêm Sinh Viên Mới</h2>
        <a href="<?php echo BASE_URL; ?>/sinhvien/index" class="btn btn-secondary btn-sm">Quay lại</a>
    </div>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form action="<?php echo BASE_URL; ?>/sinhvien/create" method="POST">
        <div class="form-group">
            <label class="form-label" for="mssv">Mã số sinh viên (MSSV) <span style="color: var(--danger);">*</span></label>
            <input type="text" id="mssv" name="mssv" class="form-control" placeholder="Ví dụ: 0000568" required autofocus>
        </div>

        <div class="form-group">
            <label class="form-label" for="hoten">Họ và Tên <span style="color: var(--danger);">*</span></label>
            <input type="text" id="hoten" name="hoten" class="form-control" placeholder="Ví dụ: Kiều Tuấn Anh" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="malop">Lớp học <span style="color: var(--danger);">*</span></label>
            <select id="malop" name="malop" class="form-control" required>
                <option value="">-- Chọn Lớp Học --</option>
                <?php foreach ($classes as $class): ?>
                    <option value="<?php echo htmlspecialchars($class['malop']); ?>">
                        <?php echo htmlspecialchars($class['malop'] . ' - ' . $class['tenlop']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label class="form-label" for="ngaysinh">Ngày sinh</label>
            <input type="date" id="ngaysinh" name="ngaysinh" class="form-control">
        </div>

        <div class="form-group">
            <label class="form-label" for="gioitinh">Giới tính</label>
            <select id="gioitinh" name="gioitinh" class="form-control">
                <option value="Nam">Nam</option>
                <option value="Nữ">Nữ</option>
                <option value="Khác">Khác</option>
            </select>
        </div>

        <div class="form-group">
            <label class="form-label" for="quequan">Quê quán</label>
            <input type="text" id="quequan" name="quequan" class="form-control" placeholder="Ví dụ: Hà Nội">
        </div>

        <div style="display: flex; gap: 12px; margin-top: 24px; justify-content: flex-end;">
            <a href="<?php echo BASE_URL; ?>/sinhvien/index" class="btn btn-secondary">Hủy bỏ</a>
            <button type="submit" class="btn btn-primary">Lưu lại</button>
        </div>
    </form>
</div>
