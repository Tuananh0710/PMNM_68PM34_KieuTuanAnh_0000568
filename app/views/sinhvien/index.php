<?php
$students = $data['students'] ?? [];
$search = $data['search'] ?? '';
$sortField = $data['sortField'] ?? 'mssv';
$sortOrder = $data['sortOrder'] ?? 'asc';
$page = $data['page'] ?? 1;
$pageSize = $data['pageSize'] ?? 10;
$totalPages = $data['totalPages'] ?? 1;
$totalStudents = $data['totalStudents'] ?? 0;

// Helper to toggle sort order
$nextSortOrder = ($sortOrder === 'asc') ? 'desc' : 'asc';

// Helper to build URL with query params intact
function getFilterUrl($params, $search, $sortField, $sortOrder, $page, $pageSize) {
    $defaults = [
        'search' => $search,
        'sortField' => $sortField,
        'sortOrder' => $sortOrder,
        'page' => $page,
        'pageSize' => $pageSize
    ];
    $merged = array_merge($defaults, $params);
    return BASE_URL . '/sinhvien/index?' . http_build_query($merged);
}
?>

<div class="card">
    <!-- Filter and Search Header -->
    <div class="filter-panel">
        <form action="<?php echo BASE_URL; ?>/sinhvien/index" method="GET" style="display: flex; gap: 8px; flex-grow: 1; max-width: 500px;">
            <!-- Keep sorting and page size preferences -->
            <input type="hidden" name="sortField" value="<?php echo htmlspecialchars($sortField); ?>">
            <input type="hidden" name="sortOrder" value="<?php echo htmlspecialchars($sortOrder); ?>">
            <input type="hidden" name="pageSize" value="<?php echo htmlspecialchars($pageSize); ?>">
            <input type="hidden" name="page" value="1">
            
            <div class="search-box" style="flex-grow: 1;">
                <input type="text" name="search" class="form-control" placeholder="Tìm theo MSSV, Họ tên hoặc Lớp..." value="<?php echo htmlspecialchars($search); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            <?php if (!empty($search)): ?>
                <a href="<?php echo BASE_URL; ?>/sinhvien/index?pageSize=<?php echo $pageSize; ?>" class="btn btn-secondary">Đặt lại</a>
            <?php endif; ?>
        </form>

        <div class="filter-actions">
            <!-- Choose Page Size Dropdown -->
            <div class="page-size-selector">
                <label for="pageSizeSelect">Số dòng hiển thị:</label>
                <select id="pageSizeSelect" onchange="window.location.href = this.value;">
                    <?php foreach ([2, 5, 10, 25, 50, 100] as $size): ?>
                        <?php $url = getFilterUrl(['pageSize' => $size, 'page' => 1], $search, $sortField, $sortOrder, $page, $pageSize); ?>
                        <option value="<?php echo $url; ?>" <?php echo $pageSize == $size ? 'selected' : ''; ?>>
                            <?php echo $size; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <a href="<?php echo BASE_URL; ?>/sinhvien/create" class="btn btn-primary">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="margin-right: 4px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path>
                </svg>
                Thêm Sinh Viên
            </a>
        </div>
    </div>

    <!-- Student Table Grid -->
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>
                        <a href="<?php echo getFilterUrl(['sortField' => 'mssv', 'sortOrder' => ($sortField === 'mssv' ? $nextSortOrder : 'asc'), 'page' => 1], $search, $sortField, $sortOrder, $page, $pageSize); ?>">
                            MSSV
                            <?php if ($sortField === 'mssv'): ?>
                                <span><?php echo $sortOrder === 'asc' ? '↑' : '↓'; ?></span>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>
                        <a href="<?php echo getFilterUrl(['sortField' => 'hoten', 'sortOrder' => ($sortField === 'hoten' ? $nextSortOrder : 'asc'), 'page' => 1], $search, $sortField, $sortOrder, $page, $pageSize); ?>">
                            Họ và Tên
                            <?php if ($sortField === 'hoten'): ?>
                                <span><?php echo $sortOrder === 'asc' ? '↑' : '↓'; ?></span>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>
                        <a href="<?php echo getFilterUrl(['sortField' => 'malop', 'sortOrder' => ($sortField === 'malop' ? $nextSortOrder : 'asc'), 'page' => 1], $search, $sortField, $sortOrder, $page, $pageSize); ?>">
                            Lớp
                            <?php if ($sortField === 'malop'): ?>
                                <span><?php echo $sortOrder === 'asc' ? '↑' : '↓'; ?></span>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>Ngày Sinh</th>
                    <th>Giới Tính</th>
                    <th>Quê Quán</th>
                    <th style="width: 150px; text-align: center;">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($students)): ?>
                    <tr>
                        <td colspan="7" style="text-align: center; color: var(--text-secondary); padding: 40px 0;">
                            Không tìm thấy sinh viên nào phù hợp.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($students as $sv): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($sv['mssv']); ?></strong></td>
                            <td><?php echo htmlspecialchars($sv['hoten']); ?></td>
                            <td>
                                <span class="badge badge-info">
                                    <?php echo htmlspecialchars($sv['malop']); ?>
                                </span>
                                <span style="font-size: 12px; color: var(--text-secondary); margin-left: 4px;">
                                    - <?php echo htmlspecialchars($sv['tenlop'] ?? 'Chưa xác định'); ?>
                                </span>
                            </td>
                            <td><?php echo $sv['ngaysinh'] ? date('d/m/Y', strtotime($sv['ngaysinh'])) : 'Chưa nhập'; ?></td>
                            <td>
                                <span class="badge <?php echo $sv['gioitinh'] === 'Nam' ? 'badge-success' : 'badge-info'; ?>">
                                    <?php echo htmlspecialchars($sv['gioitinh'] ?? 'Chưa nhập'); ?>
                                </span>
                            </td>
                            <td><?php echo htmlspecialchars($sv['quequan'] ?? 'Chưa nhập'); ?></td>
                            <td>
                                <div class="actions-cell">
                                    <a href="<?php echo BASE_URL; ?>/sinhvien/update/<?php echo $sv['id']; ?>" class="btn btn-secondary btn-sm" style="color: var(--accent);">
                                        Sửa
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>/sinhvien/delete/<?php echo $sv['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa sinh viên <?php echo htmlspecialchars($sv['hoten']); ?>?');">
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

    <!-- Pagination Footer -->
    <?php if ($totalPages > 1): ?>
        <div class="pagination-container">
            <div class="pagination-info">
                Hiển thị trang <strong><?php echo $page; ?></strong> / <strong><?php echo $totalPages; ?></strong> (Tổng số: <?php echo $totalStudents; ?> sinh viên)
            </div>
            <div class="pagination-controls">
                <!-- First and Prev Links -->
                <a href="<?php echo getFilterUrl(['page' => 1], $search, $sortField, $sortOrder, $page, $pageSize); ?>" class="pagination-link <?php echo $page <= 1 ? 'disabled' : ''; ?>" title="Trang đầu">
                    &laquo;
                </a>
                <a href="<?php echo getFilterUrl(['page' => $page - 1], $search, $sortField, $sortOrder, $page, $pageSize); ?>" class="pagination-link <?php echo $page <= 1 ? 'disabled' : ''; ?>" title="Trang trước">
                    &lsaquo;
                </a>

                <!-- Number Links -->
                <?php 
                $startPage = max(1, $page - 2);
                $endPage = min($totalPages, $page + 2);
                for ($i = $startPage; $i <= $endPage; $i++): 
                ?>
                    <a href="<?php echo getFilterUrl(['page' => $i], $search, $sortField, $sortOrder, $page, $pageSize); ?>" class="pagination-link <?php echo $page == $i ? 'active' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>

                <!-- Next and Last Links -->
                <a href="<?php echo getFilterUrl(['page' => $page + 1], $search, $sortField, $sortOrder, $page, $pageSize); ?>" class="pagination-link <?php echo $page >= $totalPages ? 'disabled' : ''; ?>" title="Trang sau">
                    &rsaquo;
                </a>
                <a href="<?php echo getFilterUrl(['page' => $totalPages], $search, $sortField, $sortOrder, $page, $pageSize); ?>" class="pagination-link <?php echo $page >= $totalPages ? 'disabled' : ''; ?>" title="Trang cuối">
                    &raquo;
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="pagination-container" style="justify-content: flex-end;">
            <div class="pagination-info">
                Tổng cộng: <strong><?php echo $totalStudents; ?></strong> sinh viên.
            </div>
        </div>
    <?php endif; ?>
</div>
