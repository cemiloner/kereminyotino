<?php
namespace App\Models;

use RedBeanPHP\R as R;

class ProductModel
{
    /**
     * Tüm ürünleri getir
     * @return array
     */
    public static function all()
    {
        return R::findAll('products');
    }
    
    /**
     * Belirtilen ID'ye sahip ürünü getir
     * @param int $id
     * @return object|null
     */
    public static function find($id)
    {
        return R::load('products', $id);
    }

    /**
     * Yeni ürün oluştur
     * @param array $data
     * @return int|bool Başarılı ise ürün ID'si, değilse false
     */
    public static function create($data)
    {
        $product = R::dispense('products');
        $product->name = $data['name'] ?? 'Ürün Adı';
        $product->price = $data['price'] ?? 0;
        $product->stock = $data['stock'] ?? 0;
        $product->image = $data['image'] ?? null;
        
        if (!empty($data['category_id'])) {
            $product->category_id = $data['category_id'];
        }
        
        try {
            return R::store($product);
        } catch (\Exception $e) {
            error_log('Ürün oluşturma hatası: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Ürün güncelle
     * @param array $data
     * @return bool
     */
    public static function update($data)
    {
        if (empty($data['id'])) {
            return false;
        }
        
        $product = R::load('products', $data['id']);
        
        if ($product->id) {
            $product->name = $data['name'] ?? $product->name;
            $product->price = $data['price'] ?? $product->price;
            $product->stock = $data['stock'] ?? $product->stock;
            
            if (isset($data['image']) && $data['image']) {
                $product->image = $data['image'];
            }
            
            if (isset($data['category_id'])) {
                $product->category_id = $data['category_id'];
            }
            
            try {
                R::store($product);
                return true;
            } catch (\Exception $e) {
                error_log('Ürün güncelleme hatası: ' . $e->getMessage());
                return false;
            }
        }
        
        return false;
    }
    
    /**
     * Ürün sil
     * @param int $id
     * @return bool
     */
    public static function delete($id)
    {
        try {
            $product = R::load('products', $id);
            
            if ($product->id) {
                // Ürünü sil
                R::trash($product);
                return true;
            }
        } catch (\Exception $e) {
            error_log('Ürün silme hatası: ' . $e->getMessage());
        }
        
        return false;
    }
    
    /**
     * Kategori ID'sine göre ürünleri getir
     * @param int $categoryId
     * @return array
     */
    public static function findByCategory($categoryId)
    {
        return R::find('products', 'category_id = ?', [$categoryId]);
    }
    
    /**
     * Toplam ürün sayısını getir
     * @return int
     */
    public static function count()
    {
        return R::count('products');
    }
}
