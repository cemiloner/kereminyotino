<?php
namespace App\Models;

use RedBeanPHP\R as R;

class OrderModel
{
    // Sipariş durumları
    const STATUS_PREPARING = 'hazırlanıyor';
    const STATUS_READY = 'hazır';
    const STATUS_DELIVERED = 'teslim edildi';
    
    /**
     * Tüm siparişleri getir
     * @return array
     */
    public static function all()
    {
        return R::findAll('orders', ' ORDER BY id DESC ');
    }
    
    /**
     * Belirtilen ID'ye sahip siparişi getir
     * @param int $id
     * @return object|null
     */
    public static function find($id)
    {
        return R::load('orders', $id);
    }
    
    /**
     * Masa numarasına göre aktif siparişleri getir
     * @param int $tableId
     * @return array
     */
    public static function findActiveByTable($tableId)
    {
        return R::find('orders', 'table_id = ? AND status != ?', [$tableId, self::STATUS_DELIVERED]);
    }

    /**
     * Yeni sipariş oluştur
     * @param array $data
     * @return int|bool Başarılı ise sipariş ID'si, değilse false
     */
    public static function create($data)
    {
        $order = R::dispense('orders');
        $order->table_id = $data['table_id'] ?? 0;
        $order->products = json_encode($data['products'] ?? []);
        $order->status = self::STATUS_PREPARING;
        $order->created_at = date('Y-m-d H:i:s');
        $order->updated_at = date('Y-m-d H:i:s');
        
        // İsteğe bağlı total_price hesaplaması
        if (!empty($data['total_price'])) {
            $order->total_price = $data['total_price'];
        } else if (!empty($data['products'])) {
            // Ürün fiyatlarından toplam hesapla
            $totalPrice = 0;
            foreach ($data['products'] as $item) {
                $product = ProductModel::find($item['product_id']);
                if ($product && $product->id) {
                    $totalPrice += $product->price * ($item['quantity'] ?? 1);
                }
            }
            $order->total_price = $totalPrice;
        }
        
        try {
            return R::store($order);
        } catch (\Exception $e) {
            error_log('Sipariş oluşturma hatası: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Sipariş durumunu güncelle
     * @param int $id
     * @param string $status
     * @return bool
     */
    public static function updateStatus($id, $status)
    {
        $order = R::load('orders', $id);
        
        if ($order->id) {
            $order->status = $status;
            $order->updated_at = date('Y-m-d H:i:s');
            
            try {
                R::store($order);
                return true;
            } catch (\Exception $e) {
                error_log('Sipariş durumu güncelleme hatası: ' . $e->getMessage());
                return false;
            }
        }
        
        return false;
    }
    
    /**
     * Sipariş sil (genelde kullanılmaz, arşivleme tercih edilir)
     * @param int $id
     * @return bool
     */
    public static function delete($id)
    {
        try {
            $order = R::load('orders', $id);
            
            if ($order->id) {
                R::trash($order);
                return true;
            }
        } catch (\Exception $e) {
            error_log('Sipariş silme hatası: ' . $e->getMessage());
        }
        
        return false;
    }
    
    /**
     * Toplam sipariş sayısını getir
     * @param string $status Belirli bir duruma göre filtreleme (opsiyonel)
     * @return int
     */
    public static function count($status = null)
    {
        if ($status) {
            return R::count('orders', 'status = ?', [$status]);
        }
        return R::count('orders');
    }
}