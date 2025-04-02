<?php
namespace App\Controllers;

use App\Models\ProductModel;

class AdminController
{
    public function index()
    {
        echo "<h2>AdminController -> index metodu</h2>";
        // Örneğin admin anasayfası
    }

    public function products($param = null)
    {
        // 1. Model üzerinden ürünleri çek
        $products = ProductModel::all();

        // 2. products.php view'ini çağır
        // products değişkenini görüntüye (include) verelim
        require __DIR__ . '/../Views/admin/products.php';
    }

    public function add($param = null)
    {
        // Örnek: yeni ürün ekleme sayfası
        echo "<h2>AdminController -> add metodu</h2>";
    }
}
