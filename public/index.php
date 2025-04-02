<?php
// Otomatik yüklemeler
require_once __DIR__ . '/../vendor/autoload.php'; // Düzeltildi: ../vendor yoluna işaret ediyor

use RedBeanPHP\R as R;

// PostgreSQL PDO bağlantısı
try {
    $host = 'db';
    $dbname = 'mydatabase';
    $user = 'myuser';
    $pass = 'mypassword';

    $dsn = "pgsql:host=$host;dbname=$dbname";
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "<div style='color: green; font-weight: bold;'>Veritabanına başarıyla bağlanıldı!</div>";

    // Veritabanı bağlantısı (RedBean kullanıyorsanız)
    R::setup('pgsql:host=db;dbname=mydatabase','myuser','mypassword');
} catch (PDOException $e) {
    echo "<div style='color: red; font-weight: bold;'>Veritabanına bağlanılamadı: " . $e->getMessage() . "</div>";
}

// path parametresini al
$path = $_GET['path'] ?? '';

// Parametreleri parçala
$segments = explode('/', trim($path, '/'));

// Varsayılan değerler
$controllerName = !empty($segments[0]) ? $segments[0] : 'home';
$methodName     = !empty($segments[1]) ? $segments[1] : 'index';
$idOrParam      = !empty($segments[2]) ? $segments[2] : null;

// Controller sınıfı adı belirle
$controllerClass = '\\App\\Controllers\\' . ucfirst($controllerName) . 'Controller';

// Debug mesajı
echo "Aranan kontrolör: " . $controllerClass . "<br>";

// Sınıfı var mı kontrol et
if (class_exists($controllerClass)) {
    $controller = new $controllerClass();

    // Metot var mı kontrol et
    if (method_exists($controller, $methodName)) {
        // Çağır ve parametreyi ilet
        $controller->$methodName($idOrParam);
    } else {
        echo "Metot bulunamadı: $methodName";
    }
} else {
    echo "Kontrolör bulunamadı: $controllerClass";

    // Mevcut kontrolörleri listele
    echo "<br>Mevcut sınıflar:<br>";
    foreach(get_declared_classes() as $class) {
        if (str_starts_with($class, 'App\\Controllers\\')) {
            echo "- $class<br>";
        }
    }
}