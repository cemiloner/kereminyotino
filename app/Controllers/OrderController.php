<?php

use RedBeanPHP\R;

class OrderController {
    public function store() {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // AJAX isteği olup olmadığını kontrol et
                $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                         strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

                $product_id = $_POST['product_id'] ?? null;
                $quantity = $_POST['quantity'] ?? 1;
                
                if ($product_id) {
                    // Ürünün varlığını kontrol et
                    $product = R::load('products', $product_id);
                    if (!$product->id) {
                        throw new Exception('Ürün bulunamadı!');
                    }

                    $order = R::dispense('orders');
                    $order->product_id = $product_id;
                    $order->quantity = $quantity;
                    $order->status = 'new'; // Durumlar: new, preparing, ready, delivered
                    $order->created_at = date('Y-m-d H:i:s');
                    $order->updated_at = date('Y-m-d H:i:s');
                    
                    $id = R::store($order);
                    
                    if ($isAjax) {
                        $this->sendJsonResponse(true, 'Siparişiniz başarıyla alındı!', ['order_id' => $id]);
                    } else {
                        $_SESSION['success'] = 'Siparişiniz başarıyla alındı!';
                        header('Location: /menu');
                        exit;
                    }
                } else {
                    throw new Exception('Geçersiz sipariş bilgileri!');
                }
            } else {
                throw new Exception('Geçersiz istek metodu!');
            }
        } catch (Exception $e) {
            if (isset($isAjax) && $isAjax) {
                $this->sendJsonResponse(false, $e->getMessage(), null, $e->getCode() ?: 400);
            } else {
                $_SESSION['error'] = $e->getMessage();
                header('Location: /menu');
                exit;
            }
        }
    }

    public function updateStatus() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $order_id = $_POST['order_id'] ?? null;
            $new_status = $_POST['status'] ?? null;
            
            if ($order_id && $new_status) {
                $order = R::load('orders', $order_id);
                if ($order->id) {
                    $order->status = $new_status;
                    $order->updated_at = date('Y-m-d H:i:s');
                    R::store($order);
                    
                    $_SESSION['success'] = 'Sipariş durumu güncellendi!';
                }
            }
        }
        
        header('Location: /admin/orders');
        exit;
    }

    private function sendJsonResponse($success, $message, $data = null, $statusCode = 200) {
        ob_clean(); // Önceki çıktıları temizle
        if (!headers_sent()) {
            header('Content-Type: application/json');
            header('Cache-Control: no-cache, must-revalidate');
            header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
            if ($statusCode !== 200) {
                http_response_code($statusCode);
            }
        }
        
        echo json_encode([
            'success' => $success,
            'message' => $message,
            'data' => $data
        ]);
        exit;
    }
} 