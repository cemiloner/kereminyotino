<?php
// Hata raporlamasını aktif et (geliştirme ortamı için)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Composer autoloader'ını dahil et
require_once __DIR__ . '/../vendor/autoload.php';

// RedBeanPHP için kısa alias tanımla - Autoloader ile yüklenecek
use RedBeanPHP\R;

// PostgreSQL PDO bağlantısı
try {
    $host = 'db';
    $dbname = 'mydatabase';
    $user = 'myuser';
    $pass = 'mypassword';

    // Normal PDO bağlantısı
    $dsn = "pgsql:host=$host;dbname=$dbname";
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "<div style='color: green; font-weight: bold;'>Veritabanına başarıyla bağlanıldı!</div>";

    // RedBeanPHP ile veritabanı bağlantısı
    R::setup('pgsql:host=db;dbname=mydatabase','myuser','mypassword');
    echo "<div style='color: green; font-weight: bold;'>RedBeanPHP başarıyla yüklendi!</div>";

    // Test amaçlı basit bir sorgu çalıştır
    try {
        $result = R::getCell("SELECT 1");
        echo "<div style='color: green; font-weight: bold;'>Test sorgusu başarılı: $result</div>";
    } catch (Exception $e) {
        echo "<div style='color: orange; font-weight: bold;'>Test sorgusu çalışırken uyarı: " . $e->getMessage() . "</div>";
    }
    
} catch (PDOException $e) {
    echo "<div style='color: red; font-weight: bold;'>Veritabanına bağlanılamadı: " . $e->getMessage() . "</div>";
} catch (Exception $e) {
    echo "<div style='color: red; font-weight: bold;'>Hata oluştu: " . $e->getMessage() . "</div>";
}

// Mevcut App namespace'indeki sınıflardan bazılarını kontrol et
echo "<div style='margin-top: 20px; padding: 10px; background-color: #f5f5f5;'>";
echo "<strong>Autoloader Durumu:</strong><br>";
echo "HomeController sınıfı: " . (class_exists('\\App\\Controllers\\HomeController') ? 'Var' : 'Yok') . "<br>";
echo "ProductModel sınıfı: " . (class_exists('\\App\\Models\\ProductModel') ? 'Var' : 'Yok') . "<br>";
echo "</div>";

// URL yönlendirme işlemleri 
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
echo "<div style='margin-top: 10px;'>";
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
echo "</div>";