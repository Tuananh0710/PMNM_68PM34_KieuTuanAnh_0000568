<?php
$classes = $data['classes'] ?? [];
?>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; border-bottom: 1.5px solid var(--border-color); padding-bottom: 12px;">
        <h2 style="font-weight: 700; font-size: 20px; color: var(--text-primary);">Danh Sách Lớp Học</h2>
        <a href="<?php echo BASE_URL; ?>/lophoc/create" class="btn btn-primary">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="margin-right: 4px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path>
            </svg>
            Thêm Lớp Học
        </a>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 80px;">STT</th>
                    <th>Mã Lớp</th>
                    <th>Tên Lớp Học</th>
                    <th>Ngày Tạo</th>
                    <th style="width: 150px; text-align: center;">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($classes)): ?>
                    <tr>
                        <td colspan="5" style="text-align: center; color: var(--text-secondary); padding: 40px 0;">
                            Chưa có lớp học nào trong hệ thống.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php 
                    $stt = 1;
                    foreach ($classes as $class): 
                    ?>
                        <tr>
                            <td><?php echo $stt++; ?></td>
                            <td><span class="badge badge-info" style="font-size: 13px;"><?php echo htmlspecialchars($class['malop']); ?></span></td>
                            <td><strong><?php echo htmlspecialchars($class['tenlop']); ?></strong></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($class['created_at'])); ?></td>
                            <td>
                                <div class="actions-cell">
                                    <a href="<?php echo BASE_URL; ?>/lophoc/update/<?php echo $class['id']; ?>" class="btn btn-secondary btn-sm" style="color: var(--accent);">
                                        Sửa
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>/lophoc/delete/<?php echo $class['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Chú ý: Xóa lớp học này sẽ xóa toàn bộ sinh viên thuộc lớp này! Bạn vẫn muốn tiếp tục chứ?');">
                                        Xóa
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
