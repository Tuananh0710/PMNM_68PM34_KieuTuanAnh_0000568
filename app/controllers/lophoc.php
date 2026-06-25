<?php
class Lophoc extends Controller
{
    private $lophocModel;

    public function __construct()
    {
        $this->lophocModel = $this->model('LophocModel');
    }

    public function index()
    {
        $classes = $this->lophocModel->getAll();
        $this->view('lophoc/index', ['classes' => $classes]);
    }

    public function create()
    {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $malop = strtoupper(trim($_POST['malop'] ?? ''));
            $tenlop = trim($_POST['tenlop'] ?? '');

            if (empty($malop) || empty($tenlop)) {
                $error = 'Vui lòng nhập đầy đủ thông tin!';
            } else {
                $existing = $this->lophocModel->getByMalop($malop);
                if ($existing) {
                    $error = 'Mã lớp này đã tồn tại!';
                } else {
                    if ($this->lophocModel->create($malop, $tenlop)) {
                        $this->redirect('lophoc/index');
                    } else {
                        $error = 'Có lỗi xảy ra khi thêm mới!';
                    }
                }
            }
        }
        $this->view('lophoc/create', ['error' => $error]);
    }

    public function update($id = null)
    {
        if (!$id) {
            $this->redirect('lophoc/index');
        }

        $class = $this->lophocModel->getById($id);
        if (!$class) {
            $this->redirect('lophoc/index');
        }

        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $malop = strtoupper(trim($_POST['malop'] ?? ''));
            $tenlop = trim($_POST['tenlop'] ?? '');

            if (empty($malop) || empty($tenlop)) {
                $error = 'Vui lòng nhập đầy đủ thông tin!';
            } else {
                $existing = $this->lophocModel->getByMalop($malop);
                if ($existing && $existing['id'] != $id) {
                    $error = 'Mã lớp này đã được sử dụng bởi lớp khác!';
                } else {
                    if ($this->lophocModel->update($id, $malop, $tenlop)) {
                        $this->redirect('lophoc/index');
                    } else {
                        $error = 'Có lỗi xảy ra khi cập nhật!';
                    }
                }
            }
        }

        $this->view('lophoc/update', [
            'class' => $class,
            'error' => $error
        ]);
    }

    public function delete($id = null)
    {
        if ($id) {
            $this->lophocModel->delete($id);
        }
        $this->redirect('lophoc/index');
    }
}
?>
