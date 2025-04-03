<?php
namespace App\Models;

use RedBeanPHP\R as R;

class CategoryModel
{
    /**
     * Tüm kategorileri getir
     * @return array
     */
    public static function all()
    {
        return R::findAll('categories');
    }
    
    /**
     * Belirtilen ID'ye sahip kategoriyi getir
     * @param int $id
     * @return object|null
     */
    public static function find($id)
    {
        return R::load('categories', $id);
    }
    
    /**
     * Yeni kategori oluştur
     * @param array $data
     * @return int|bool Başarılı ise kategori ID'si, değilse false
     */
    public static function create($data)
    {
        $category = R::dispense('categories');
        $category->name = $data['name'] ?? '';
        
        try {
            return R::store($category);
        } catch (\Exception $e) {
            error_log('Kategori oluşturma hatası: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Kategori güncelle
     * @param array $data
     * @return bool
     */
    public static function update($data)
    {
        if (empty($data['id'])) {
            return false;
        }
        
        $category = R::load('categories', $data['id']);
        
        if ($category->id) {
            $category->name = $data['name'] ?? $category->name;
            
            try {
                R::store($category);
                return true;
            } catch (\Exception $e) {
                error_log('Kategori güncelleme hatası: ' . $e->getMessage());
                return false;
            }
        }
        
        return false;
    }
    
    /**
     * Kategori sil
     * @param int $id
     * @return bool
     */
    public static function delete($id)
    {
        try {
            $category = R::load('categories', $id);
            
            if ($category->id) {
                // İlgili ürünleri bul
                $products = R::find('products', 'category_id = ?', [$id]);
                
                // İlgili ürünlerin kategori bağlantısını kaldır
                foreach ($products as $product) {
                    $product->category_id = null;
                    R::store($product);
                }
                
                // Kategoriyi sil
                R::trash($category);
                return true;
            }
        } catch (\Exception $e) {
            error_log('Kategori silme hatası: ' . $e->getMessage());
        }
        
        return false;
    }

    /**
     * Toplam kategori sayısını getir
     * @return int
     */
    public static function count()
    {
        return R::count('categories');
    }
}