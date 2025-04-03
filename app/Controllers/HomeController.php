<?php
namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Models\OrderModel;

class HomeController
{
    /**
     * Anasayfa
     */
    public function index()
    {
        echo '<h1>Restoran Anasayfa</h1>';
        echo '<p>Bu müşteri arayüzü henüz geliştirilmektedir.</p>';
        echo '<p><a href="/admin">Admin Paneline Git</a></p>';
    }
    
    /**
     * Menü sayfası
     */
    public function menu()
    {
        $categories = CategoryModel::all();
        
        echo '<h1>Restoran Menüsü</h1>';
        
        foreach ($categories as $category) {
            echo '<h2>' . htmlspecialchars($category->name) . '</h2>';
            
            // Kategoriye ait ürünleri getir
            $products = ProductModel::findByCategory($category->id);
            
            if (count($products) > 0) {
                echo '<ul>';
                foreach ($products as $product) {
                    echo '<li>' . htmlspecialchars($product->name) . ' - ' . 
                         number_format($product->price, 2) . ' TL</li>';
                }
                echo '</ul>';
            } else {
                echo '<p>Bu kategoride henüz ürün bulunmamaktadır.</p>';
            }
        }
        
        echo '<p><a href="/">Anasayfaya Dön</a> | <a href="/admin">Admin Paneline Git</a></p>';
    }
    
    /**
     * Sipariş verme sayfası (basitleştirilmiş örnek)
     */
    public function order()
    {
        echo '<h1>Sipariş Sayfası</h1>';
        echo '<p>Bu sipariş arayüzü henüz geliştirilmektedir.</p>';
        echo '<p><a href="/menu">Menüye Dön</a> | <a href="/">Anasayfaya Dön</a></p>';
    }
}