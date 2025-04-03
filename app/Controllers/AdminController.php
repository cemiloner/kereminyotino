<?php
namespace App\Controllers;

use App\Models\AuthModel;
use App\Models\ProductModel;

class AdminController
{
    public function index()
    {
        return view_with_layout('admin/dashboard', [
            'title' => 'Admin Dashboard'
        ]);
    }

    // ------------------ Authentication ------------------
    
    public function login()
    {
        // Post request ise giriş işlemi yap
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            $token = AuthModel::login($username, $password);
            
            if ($token) {
                // Token'ı cookie olarak kaydet (7 gün geçerli)
                setcookie('admin_token', $token, time() + (7 * 24 * 60 * 60), '/', '', false, true);
                
                // Başarılı giriş, admin paneline yönlendir
                header('Location: /admin');
                exit;
            } else {
                $error = 'Kullanıcı adı veya şifre hatalı!';
                return view('admin/login', ['error' => $error]);
            }
        }
        
        // GET request ise login formu göster - Login sayfası için layout kullanmıyoruz
        return view('admin/login');
    }
    
    public function logout()
    {
        // Cookie'yi sil
        setcookie('admin_token', '', time() - 3600, '/');
        
        // Login sayfasına yönlendir
        header('Location: /admin/login');
        exit;
    }
    
    // ------------------ Products CRUD ------------------
    
    public function products($id = null)
    {
        // Tüm ürünleri göster
        $products = ProductModel::all();
        return view_with_layout('admin/products', [
            'products' => $products,
            'title' => 'Ürün Listesi'
        ]);
    }
    
    public function productCreate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Form gönderilmiş, ürün ekleme işlemi
            $data = [
                'name' => $_POST['name'] ?? '',
                'price' => $_POST['price'] ?? 0,
                'stock' => $_POST['stock'] ?? 0,
                'category_id' => $_POST['category_id'] ?? null
            ];
            
            // İsteğe bağlı resim yükleme işlemi
            if (!empty($_FILES['image']['name'])) {
                $uploadDir = __DIR__ . '/../../public/uploads/';
                $fileName = time() . '_' . basename($_FILES['image']['name']);
                $filePath = $uploadDir . $fileName;
                
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $filePath)) {
                    $data['image'] = '/uploads/' . $fileName;
                }
            }
            
            // ProductModel üzerinden ürün ekle
            $id = ProductModel::create($data);
            
            if ($id) {
                header('Location: /admin/products');
                exit;
            } else {
                $error = 'Ürün eklenirken bir hata oluştu';
            }
        }
        
        // Kategori listesini al
        $categories = \App\Models\CategoryModel::all();
        
        // Form göster
        return view_with_layout('admin/product_form', [
            'categories' => $categories,
            'title' => 'Yeni Ürün Ekle'
        ]);
    }
    
    public function productEdit($id = null)
    {
        if ($id === null) {
            $id = $_GET['id'] ?? null;
        }
        
        if (!$id) {
            header('Location: /admin/products');
            exit;
        }
        
        $product = ProductModel::find($id);
        
        if (!$product) {
            header('Location: /admin/products');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Form gönderilmiş, ürün güncelleme işlemi
            $data = [
                'id' => $id,
                'name' => $_POST['name'] ?? '',
                'price' => $_POST['price'] ?? 0,
                'stock' => $_POST['stock'] ?? 0,
                'category_id' => $_POST['category_id'] ?? null
            ];
            
            // İsteğe bağlı resim yükleme işlemi
            if (!empty($_FILES['image']['name'])) {
                $uploadDir = __DIR__ . '/../../public/uploads/';
                $fileName = time() . '_' . basename($_FILES['image']['name']);
                $filePath = $uploadDir . $fileName;
                
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $filePath)) {
                    $data['image'] = '/uploads/' . $fileName;
                }
            } else {
                $data['image'] = $product->image; // Mevcut resmi koru
            }
            
            // ProductModel üzerinden ürün güncelle
            $result = ProductModel::update($data);
            
            if ($result) {
                header('Location: /admin/products');
                exit;
            } else {
                $error = 'Ürün güncellenirken bir hata oluştu';
            }
        }
        
        // Kategori listesini al
        $categories = \App\Models\CategoryModel::all();
        
        // Form göster
        return view_with_layout('admin/product_form', [
            'product' => $product,
            'categories' => $categories,
            'title' => 'Ürün Düzenle: ' . $product->name
        ]);
    }
    
    public function productDelete($id = null)
    {
        if ($id === null) {
            $id = $_GET['id'] ?? null;
        }
        
        if ($id) {
            ProductModel::delete($id);
        }
        
        header('Location: /admin/products');
        exit;
    }
    
    // ------------------ Categories CRUD ------------------
    
    public function categories($id = null)
    {
        // Tüm kategorileri göster
        $categories = \App\Models\CategoryModel::all();
        return view_with_layout('admin/categories', [
            'categories' => $categories,
            'title' => 'Kategori Listesi'
        ]);
    }
    
    public function categoryCreate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Form gönderilmiş, kategori ekleme işlemi
            $data = [
                'name' => $_POST['name'] ?? ''
            ];
            
            // CategoryModel üzerinden kategori ekle
            $id = \App\Models\CategoryModel::create($data);
            
            if ($id) {
                header('Location: /admin/categories');
                exit;
            } else {
                $error = 'Kategori eklenirken bir hata oluştu';
            }
        }
        
        // Form göster
        return view_with_layout('admin/category_form', [
            'title' => 'Yeni Kategori Ekle'
        ]);
    }
    
    public function categoryEdit($id = null)
    {
        if ($id === null) {
            $id = $_GET['id'] ?? null;
        }
        
        if (!$id) {
            header('Location: /admin/categories');
            exit;
        }
        
        $category = \App\Models\CategoryModel::find($id);
        
        if (!$category) {
            header('Location: /admin/categories');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Form gönderilmiş, kategori güncelleme işlemi
            $data = [
                'id' => $id,
                'name' => $_POST['name'] ?? ''
            ];
            
            // CategoryModel üzerinden kategori güncelle
            $result = \App\Models\CategoryModel::update($data);
            
            if ($result) {
                header('Location: /admin/categories');
                exit;
            } else {
                $error = 'Kategori güncellenirken bir hata oluştu';
            }
        }
        
        // Form göster
        return view_with_layout('admin/category_form', [
            'category' => $category,
            'title' => 'Kategori Düzenle: ' . $category->name
        ]);
    }
    
    public function categoryDelete($id = null)
    {
        if ($id === null) {
            $id = $_GET['id'] ?? null;
        }
        
        if ($id) {
            \App\Models\CategoryModel::delete($id);
        }
        
        header('Location: /admin/categories');
        exit;
    }
    
    // ------------------ Orders Management ------------------
    
    public function orders($id = null)
    {
        // Tüm siparişleri göster
        $orders = \App\Models\OrderModel::all();
        return view_with_layout('admin/orders', [
            'orders' => $orders,
            'title' => 'Sipariş Listesi'
        ]);
    }
    
    public function orderDetail($id = null)
    {
        if ($id === null) {
            $id = $_GET['id'] ?? null;
        }
        
        if (!$id) {
            header('Location: /admin/orders');
            exit;
        }

        $orderModel = new \App\Models\OrderModel();
        $order = $orderModel->find($id);

        if (!$order) {
            header('Location: /admin/orders');
            exit;
        }
        
        // Sipariş detayını göster
        return view_with_layout('admin/order_detail', [
            'order' => $order,
            'title' => 'Sipariş Detayı #' . $id
        ]);
    }
    
    public function orderUpdateStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['order_id'] ?? null;
            $status = $_POST['status'] ?? null;
            
            if ($id && $status) {
                \App\Models\OrderModel::updateStatus($id, $status);
            }
            
            header('Location: /admin/orders');
            exit;
        }
        
        header('Location: /admin/orders');
        exit;
    }
}
