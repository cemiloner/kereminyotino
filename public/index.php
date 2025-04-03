<?php
// Composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// RedBeanPHP database connection
require_once __DIR__ . '/../config/database.php';

// Request URI'yi analiz et
$requestUri = $_SERVER['REQUEST_URI'];
$requestUri = trim(parse_url($requestUri, PHP_URL_PATH), '/');

// Route mapping - Basit bir routing mekanizması
$routes = [
    // Admin routes
    'admin' => ['App\Controllers\AdminController', 'index'],
    'admin/login' => ['App\Controllers\AdminController', 'login'],
    'admin/logout' => ['App\Controllers\AdminController', 'logout'],
    
    // Product routes
    'admin/products' => ['App\Controllers\AdminController', 'products'],
    'admin/products/create' => ['App\Controllers\AdminController', 'productCreate'],
    'admin/products/edit' => ['App\Controllers\AdminController', 'productEdit'],
    'admin/products/delete' => ['App\Controllers\AdminController', 'productDelete'],
    
    // Category routes
    'admin/categories' => ['App\Controllers\AdminController', 'categories'],
    'admin/categories/create' => ['App\Controllers\AdminController', 'categoryCreate'],
    'admin/categories/edit' => ['App\Controllers\AdminController', 'categoryEdit'],
    'admin/categories/delete' => ['App\Controllers\AdminController', 'categoryDelete'],
    
    // Order routes
    'admin/orders' => ['App\Controllers\AdminController', 'orders'],
    'admin/orders/detail' => ['App\Controllers\AdminController', 'orderDetail'],
    'admin/orders/update-status' => ['App\Controllers\AdminController', 'orderUpdateStatus'],
    
    // Default front routes (for customers)
    '' => ['App\Controllers\HomeController', 'index'],
    'menu' => ['App\Controllers\HomeController', 'menu'],
    'order' => ['App\Controllers\HomeController', 'order'],
];

// Admin route koruma middleware'i uygula
App\Middleware\AuthMiddleware::protectAdminRoutes($requestUri);

// İstek yapılan rota var mı?
if (isset($routes[$requestUri])) {
    // Controller ve metod bilgilerini al
    list($controllerClass, $method) = $routes[$requestUri];
    
    // Controller örneğini oluştur
    $controller = new $controllerClass();
    
    // İlgili metodu çağır
    call_user_func([$controller, $method]);
} else {
    // 404 hatası
    header('HTTP/1.0 404 Not Found');
    echo '<h1>404 Not Found</h1>';
    echo '<p>İstediğiniz sayfa bulunamadı.</p>';
}