<?php

// .env dosyasını yükle
if (file_exists(__DIR__ . '/../.env')) {
    $lines = file(__DIR__ . '/../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (str_contains($line, '=')) {
            list($key, $value) = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
            putenv(sprintf('%s=%s', trim($key), trim($value)));
        }
    }
}
// Import RedBeanPHP
require_once __DIR__ . '/../vendor/autoload.php';

use RedBeanPHP\R as R;

// PostgreSQL bağlantısı için parametreler
$dbHost = getenv('DB_HOST') ?: 'db'; // Docker Compose'da tanımlanan servis adı
$dbName = getenv('DB_NAME') ?: 'postgres';
$dbUser = getenv('DB_USER') ?: 'postgres';
$dbPass = getenv('DB_PASS') ?: 'postgres';

try {
    // PostgreSQL için DSN formatı
    $dsn = "pgsql:host=$dbHost;dbname=$dbName";
    
    // RedBeanPHP'yi PostgreSQL ile yapılandır
    R::setup($dsn, $dbUser, $dbPass);
    
    // RedBeanPHP dondurma modu (frozen) - geliştirme ortamında false
    $isProduction = getenv('APP_ENV') === 'production';
    R::freeze($isProduction);
    
    // Bağlantı kontrolü
    if (!R::testConnection()) {
        throw new Exception('Veritabanı bağlantısı kurulamadı.');
    }
    
} catch (Exception $e) {
    // Hata durumunda
    die('Veritabanı bağlantı hatası: ' . $e->getMessage());
}

// Geliştirme modunda tablo oluşturma ve örnek veri ekleme
if (getenv('APP_ENV') !== 'production' && !R::count('products')) {
    // Örnek kategoriler
    $category1 = R::dispense('categories');
    $category1->name = 'Ana Yemekler';
    R::store($category1);
    
    $category2 = R::dispense('categories');
    $category2->name = 'İçecekler';
    R::store($category2);
    
    // Örnek ürünler
    $product1 = R::dispense('products');
    $product1->name = 'Köfte';
    $product1->price = 45.00;
    $product1->stock = 100;
    $product1->category_id = $category1->id;
    R::store($product1);
    
    $product2 = R::dispense('products');
    $product2->name = 'Ayran';
    $product2->price = 7.50;
    $product2->stock = 200;
    $product2->category_id = $category2->id;
    R::store($product2);
}