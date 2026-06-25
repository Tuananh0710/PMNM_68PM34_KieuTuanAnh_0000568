<?php
class App
{
    protected $controller = 'home';
    protected $action = 'index';
    protected $params = [];

    public function __construct()
    {
        $urlProcessed = $this->UrlProcess();

        // 1. Determine controller
        $targetController = $this->controller;
        if (isset($urlProcessed[0])) {
            if (file_exists('../app/controllers/' . $urlProcessed[0] . '.php')) {
                $targetController = $urlProcessed[0];
            }
        }

        // 2. Determine action
        $targetAction = $this->action;
        if (isset($urlProcessed[1])) {
            $targetAction = $urlProcessed[1];
        }

        // 3. Execute Middleware check
        require_once '../app/core/Middleware.php';
        Middleware::run($targetController, $targetAction);

        // 4. Load controller file
        if (isset($urlProcessed[0])) {
            if (file_exists('../app/controllers/' . $urlProcessed[0] . '.php')) {
                $this->controller = $urlProcessed[0];
                unset($urlProcessed[0]);
            }
        }
        require_once '../app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // 5. Load action method
        if (isset($urlProcessed[1])) {
            if (method_exists($this->controller, $urlProcessed[1])) {
                $this->action = $urlProcessed[1];
                unset($urlProcessed[1]);
            }
        }

        $this->params = $urlProcessed ? array_values($urlProcessed) : [];
        call_user_func_array([$this->controller, $this->action], $this->params);
    }
    public function UrlProcess(){
        if (isset($_GET['url'])) {
            return explode('/', filter_var(trim($_GET['url'], '/')));
        }
        return [];
    }
}

?>