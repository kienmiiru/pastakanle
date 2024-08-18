<?php

class App {
    protected $controller = 'HomeController';
    protected $parameters = [];

    public function __construct() {
        $url = $this->parseUrl();
        $httpMethod = $_SERVER['REQUEST_METHOD'];

        // Case 1: home page
        if (!isset($url[0]) || empty($url[0])) {
            $this->controller = 'HomeController';
            $this->parameters = [];
        }
        // Case 2: controller
        elseif (file_exists('../app/controllers/' . $url[0] . 'Controller.php')) {
            $this->controller = $url[0] . 'Controller';
            $this->parameters = isset($url[1]) ? [$url[1]] : [];
        }
        // Case 3: view a paste
        elseif (isset($url[0]) && !empty($url[0])) {
            $this->controller = 'ViewController';
            $this->parameters = [$url[0]];
        }
        // Case 4: not found
        else {
            $this->controller = 'HomeController'; // Nanti
            $this->parameters = [];
        }

        require_once '../app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        if (method_exists($this->controller, strtolower($httpMethod))) {
            call_user_func_array([$this->controller, strtolower($httpMethod)], $this->parameters);
        }
    }

    public function parseUrl() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL), 3);
        }
    }
}
?>
