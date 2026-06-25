<?php
class Sinhvien extends Controller
{
    private $sinhvienModel;

    public function __construct()
    {
        $this->sinhvienModel = $this->model('SinhvienModel');
    }

    public function index()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // 1. Get and persist Page Size (User Choice or Session or Default 10)
        $pageSize = 10;
        if (isset($_GET['pageSize'])) {
            $pageSize = (int)$_GET['pageSize'];
            $_SESSION['pageSize'] = $pageSize;
        } elseif (isset($_SESSION['pageSize'])) {
            $pageSize = (int)$_SESSION['pageSize'];
        }
        // Clamp page size to valid choices
        if (!in_array($pageSize, [2, 5, 10, 25, 50, 100])) {
            $pageSize = 10;
        }

        // 2. Get Page Number
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) {
            $page = 1;
        }

        // 3. Search Keyword
        $search = trim($_GET['search'] ?? '');

        // 4. Sorting Parameters
        $sortField = trim($_GET['sortField'] ?? 'mssv');
        $sortOrder = trim($_GET['sortOrder'] ?? 'asc');

        // Check if sort field is valid
        if (!in_array($sortField, ['mssv', 'hoten', 'malop'])) {
            $sortField = 'mssv';
        }
        if (!in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'asc';
        }

        // Calculate offset
        $offset = ($page - 1) * $pageSize;

        // Fetch data
        $students = $this->sinhvienModel->getAll($search, $sortField, $sortOrder, $offset, $pageSize);
        $totalStudents = $this->sinhvienModel->countAll($search);
        
        $totalPages = (int)ceil($totalStudents / $pageSize);
        if ($totalPages < 1) {
            $totalPages = 1;
        }
        if ($page > $totalPages) {
            $page = $totalPages;
            $offset = ($page - 1) * $pageSize;
            $students = $this->sinhvienModel->getAll($search, $sortField, $sortOrder, $offset, $pageSize);
        }

        $this->view('sinhvien/index', [
            'students' => $students,
            'search' => $search,
            'sortField' => $sortField,
            'sortOrder' => $sortOrder,
            'page' => $page,
            'pageSize' => $pageSize,
            'totalPages' => $totalPages,
            'totalStudents' => $totalStudents
        ]);
    }

    public function create()
    {
        $lophocModel = $this->model('LophocModel');
        $classes = $lophocModel->getAll();
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $mssv = trim($_POST['mssv'] ?? '');
            $hoten = trim($_POST['hoten'] ?? '');
            $malop = trim($_POST['malop'] ?? '');
            $ngaysinh = trim($_POST['ngaysinh'] ?? '');
            $gioitinh = trim($_POST['gioitinh'] ?? '');
            $quequan = trim($_POST['quequan'] ?? '');

            if (empty($mssv) || empty($hoten) || empty($malop)) {
                $error = 'Vui lòng nhập đầy đủ MSSV, Họ tên và chọn Lớp!';
            } else {
                $existing = $this->sinhvienModel->getByMssv($mssv);
                if ($existing) {
                    $error = 'Mã số sinh viên (MSSV) này đã tồn tại!';
                } else {
                    if ($this->sinhvienModel->create($mssv, $hoten, $malop, empty($ngaysinh) ? null : $ngaysinh, $gioitinh, $quequan)) {
                        $this->redirect('sinhvien/index');
                    } else {
                        $error = 'Có lỗi xảy ra khi thêm sinh viên!';
                    }
                }
            }
        }

        $this->view('sinhvien/create', [
            'classes' => $classes,
            'error' => $error
        ]);
    }

    public function update($id = null)
    {
        if (!$id) {
            $this->redirect('sinhvien/index');
        }

        $student = $this->sinhvienModel->getById($id);
        if (!$student) {
            $this->redirect('sinhvien/index');
        }

        $lophocModel = $this->model('LophocModel');
        $classes = $lophocModel->getAll();
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $mssv = trim($_POST['mssv'] ?? '');
            $hoten = trim($_POST['hoten'] ?? '');
            $malop = trim($_POST['malop'] ?? '');
            $ngaysinh = trim($_POST['ngaysinh'] ?? '');
            $gioitinh = trim($_POST['gioitinh'] ?? '');
            $quequan = trim($_POST['quequan'] ?? '');

            if (empty($mssv) || empty($hoten) || empty($malop)) {
                $error = 'Vui lòng nhập đầy đủ MSSV, Họ tên và chọn Lớp!';
            } else {
                $existing = $this->sinhvienModel->getByMssv($mssv);
                if ($existing && $existing['id'] != $id) {
                    $error = 'MSSV này đã được sử dụng bởi sinh viên khác!';
                } else {
                    if ($this->sinhvienModel->update($id, $mssv, $hoten, $malop, empty($ngaysinh) ? null : $ngaysinh, $gioitinh, $quequan)) {
                        $this->redirect('sinhvien/index');
                    } else {
                        $error = 'Có lỗi xảy ra khi cập nhật thông tin sinh viên!';
                    }
                }
            }
        }

        $this->view('sinhvien/update', [
            'student' => $student,
            'classes' => $classes,
            'error' => $error
        ]);
    }

    public function delete($id = null)
    {
        if ($id) {
            $this->sinhvienModel->delete($id);
        }
        $this->redirect('sinhvien/index');
    }
}
?>