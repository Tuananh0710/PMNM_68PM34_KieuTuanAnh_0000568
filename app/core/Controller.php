<?php
class Controller
{
    // Load model
    public function model($model)
    {
        $modelPath = '../app/models/' . $model . '.php';
        if (file_exists($modelPath)) {
            require_once $modelPath;
            return new $model();
        }
        return null;
    }

    // Load view
    public function view($view, $data = [])
    {
        $viewPath = '../app/views/' . $view . '.php';
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            echo "View: " . htmlspecialchars($view) . " not found!";
        }
    }

    // Redirect utility
    public function redirect($url)
    {
        header('Location: ' . BASE_URL . '/' . ltrim($url, '/'));
        exit();
    }
}
?>
