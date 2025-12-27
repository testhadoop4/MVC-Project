<?php
require_once 'config/database.php';

// Autoload classes
spl_autoload_register(function ($class_name) {
    $paths = [
        'app/controllers/',
        'app/models/',
        'app/views/'
    ];
    
    foreach ($paths as $path) {
        $file = $path . $class_name . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

class Router {
    private $routes = [
        '/' => ['controller' => 'HomeController', 'action' => 'index'],
        '/users' => ['controller' => 'UserController', 'action' => 'index'],
        '/users/create' => ['controller' => 'UserController', 'action' => 'create'],
        '/users/store' => ['controller' => 'UserController', 'action' => 'store'],
        '/users/edit' => ['controller' => 'UserController', 'action' => 'edit'],
        '/users/update' => ['controller' => 'UserController', 'action' => 'update'],
        '/users/delete' => ['controller' => 'UserController', 'action' => 'delete'],
        '/products' => ['controller' => 'ProductController', 'action' => 'index'],
        '/products/create' => ['controller' => 'ProductController', 'action' => 'create'],
        '/products/store' => ['controller' => 'ProductController', 'action' => 'store'],
        '/products/edit' => ['controller' => 'ProductController', 'action' => 'edit'],
        '/products/update' => ['controller' => 'ProductController', 'action' => 'update'],
        '/products/delete' => ['controller' => 'ProductController', 'action' => 'delete']
    ];

    public function route() {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $base_dir = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
        $path = str_replace($base_dir, '', $path);
        
        if (array_key_exists($path, $this->routes)) {
            $route = $this->routes[$path];
            $controller_name = $route['controller'];
            $action = $route['action'];
            
            $controller = new $controller_name();
            $controller->$action();
        } else {
            http_response_code(404);
            $view = new View();
            $view->set('title', 'Page Not Found');
            $view->render('404', 'main');
        }
    }
}

$router = new Router();
$router->route();
?>