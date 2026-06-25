<?php
class Middleware
{
    public static function run($controllerName, $actionName)
    {
        // Start session if not started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $controllerLower = strtolower($controllerName);
        $actionLower = strtolower($actionName);

        // Check if the current route is public
        $isPublic = ($controllerLower === 'auth' && $actionLower === 'login');

        // Check if user is logged in
        $isLoggedIn = isset($_SESSION['user']);

        if (!$isLoggedIn && !$isPublic) {
            // Not logged in and trying to access private page -> redirect to login
            header('Location: ' . BASE_URL . '/auth/login');
            exit();
        }

        if ($isLoggedIn && $isPublic) {
            // Logged in and trying to access login page -> redirect to sinhvien/index
            header('Location: ' . BASE_URL . '/sinhvien/index');
            exit();
        }
    }
}
?>
