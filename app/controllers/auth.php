<?php
class Auth extends Controller
{
    public function login()
    {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if (empty($username) || empty($password)) {
                $error = 'Vui lòng điền đầy đủ tài khoản và mật khẩu!';
            } else {
                $userModel = $this->model('UserModel');
                $user = $userModel->login($username, $password);

                if ($user) {
                    if (session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }
                    $_SESSION['user'] = $user;
                    $this->redirect('sinhvien/index');
                } else {
                    $error = 'Tài khoản hoặc mật khẩu không chính xác!';
                }
            }
        }

        $this->view('auth/login', ['error' => $error]);
    }

    public function logout()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = [];
        session_destroy();
        $this->redirect('auth/login');
    }
}
?>
