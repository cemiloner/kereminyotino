<?php
namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Models\OrderModel;
use RedBeanPHP\R;

class HomeController
{
    /**
     * Anasayfa
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Menü sayfası (görünümle birlikte)
     */
    public function menu()
    {
        // Kategorileri getir
        $categories = R::findAll('categories');
        
        // Ürünleri getir
        $products = R::findAll('products');
        
        // Görünüm dosyasına gönder
        return view('menu', [
            'categories' => $categories,
            'products' => $products
        ]);
    }

    /**
     * Sipariş verme sayfası
     */
    public function order()
    {
        echo '<h1>Sipariş Sayfası</h1>';
        echo '<p>Bu sipariş arayüzü henüz geliştirilmektedir.</p>';
        echo '<p><a href="/menu">Menüye Dön</a> | <a href="/">Anasayfaya Dön</a></p>';
    }

    public function feedback()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Form verilerini al
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $message = $_POST['message'] ?? '';
            
            // Veritabanına kaydet
            $feedback = R::dispense('feedback');
            $feedback->name = $name;
            $feedback->email = $email;
            $feedback->message = $message;
            $feedback->created_at = date('Y-m-d H:i:s');
            
            R::store($feedback);
            
            // Başarılı mesajıyla anasayfaya yönlendir
            $_SESSION['success_message'] = 'Geri bildiriminiz için teşekkür ederiz!';
            header('Location: /');
            exit;
        }
        
        // GET isteği için anasayfaya yönlendir
        header('Location: /');
        exit;
    }
}
