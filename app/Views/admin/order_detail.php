<div class="header">
    <h1>Sipariş Detayı #<?php echo $order->id; ?></h1>
    <a href="/admin/orders" class="back-btn"><i class="fas fa-arrow-left"></i> Siparişlere Dön</a>
</div>

<!-- Order Summary -->
<div class="order-details-card">
    <div class="card-header">
        <h2><i class="fas fa-info-circle"></i> Sipariş Bilgileri</h2>
    </div>
    <div class="card-body">
        <div class="detail-row">
            <div class="detail-label">Sipariş No:</div>
            <div class="detail-value">#<?php echo $order->id; ?></div>
        </div>
        
        <div class="detail-row">
            <div class="detail-label">Masa No:</div>
            <div class="detail-value">Masa <?php echo $order->table_id; ?></div>
        </div>
        
        <div class="detail-row">
            <div class="detail-label">Durum:</div>
            <div class="detail-value">
                <?php
                    $statusClass = 'status-preparing';
                    $statusIcon = 'fa-hourglass-half';
                    if ($order->status === 'hazır') {
                        $statusClass = 'status-ready';
                        $statusIcon = 'fa-check';
                    } else if ($order->status === 'teslim edildi') {
                        $statusClass = 'status-delivered';
                        $statusIcon = 'fa-check-double';
                    }
                ?>
                <span class="status-badge <?php echo $statusClass; ?>">
                    <i class="fas <?php echo $statusIcon; ?>"></i>
                    <?php echo htmlspecialchars($order->status); ?>
                </span>
            </div>
        </div>
        
        <div class="detail-row">
            <div class="detail-label">Sipariş Tarihi:</div>
            <div class="detail-value">
                <i class="far fa-calendar-alt"></i> <?php echo date('d.m.Y H:i', strtotime($order->created_at)); ?>
            </div>
        </div>
        
        <div class="detail-row">
            <div class="detail-label">Son Güncelleme:</div>
            <div class="detail-value">
                <i class="far fa-clock"></i> <?php echo date('d.m.Y H:i', strtotime($order->updated_at)); ?>
            </div>
        </div>
    </div>
</div>

<!-- Order Items -->
<div class="order-items-card">
    <div class="card-header">
        <h2><i class="fas fa-shopping-basket"></i> Sipariş Ürünleri</h2>
    </div>
    <div class="card-body order-items-container">
        <table class="order-items-table">
            <thead>
                <tr>
                    <th>Ürün</th>
                    <th>Adet</th>
                    <th>Birim Fiyat</th>
                    <th>Toplam</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $products = json_decode($order->products, true) ?? [];
                $totalAmount = 0;
                
                foreach ($products as $item):
                    $product = \App\Models\ProductModel::find($item['product_id']);
                    if (!$product->id) continue;
                    
                    $quantity = $item['quantity'] ?? 1;
                    $price = $product->price;
                    $itemTotal = $price * $quantity;
                    $totalAmount += $itemTotal;
                ?>
                <tr>
                    <td class="product-name"><?php echo htmlspecialchars($product->name); ?></td>
                    <td class="product-quantity"><?php echo $quantity; ?></td>
                    <td class="product-price"><?php echo number_format($price, 2); ?> <span class="currency">TL</span></td>
                    <td class="product-total"><?php echo number_format($itemTotal, 2); ?> <span class="currency">TL</span></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <div class="order-total">
            <span class="total-label">Toplam:</span>
            <span class="total-value"><?php echo number_format($order->total_price ?? $totalAmount, 2); ?> TL</span>
        </div>
    </div>
</div>

<!-- Actions Panel -->
<?php if ($order->status !== 'teslim edildi'): ?>
<div class="actions-card">
    <div class="card-header">
        <h2><i class="fas fa-tasks"></i> Sipariş Durumunu Güncelle</h2>
    </div>
    <div class="card-body">
        <div class="status-actions">
            <form action="/admin/orders/update-status" method="POST">
                <input type="hidden" name="order_id" value="<?php echo $order->id; ?>">
                
                <?php if ($order->status === 'hazırlanıyor'): ?>
                    <input type="hidden" name="status" value="hazır">
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-check"></i> Hazır Olarak İşaretle
                    </button>
                <?php elseif ($order->status === 'hazır'): ?>
                    <input type="hidden" name="status" value="teslim edildi">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check-double"></i> Teslim Edildi Olarak İşaretle
                    </button>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Font Awesome için CDN bağlantısı -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
/* Sipariş Detay Stilleri */
.header {
    background: linear-gradient(to right, #36b9cc, #1a8a98);
    color: white;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 25px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.header h1 {
    font-size: 24px;
    margin: 0;
    font-weight: 600;
}

.back-btn {
    background-color: rgba(255,255,255,0.2);
    color: white;
    text-decoration: none;
    padding: 8px 15px;
    border-radius: 6px;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: background-color 0.3s;
}

.back-btn:hover {
    background-color: rgba(255,255,255,0.3);
}

/* Kart Stilleri */
.order-details-card,
.order-items-card,
.actions-card {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    margin-bottom: 25px;
    overflow: hidden;
}

.card-header {
    background-color: #f8f9fc;
    padding: 15px 20px;
    border-bottom: 1px solid #e3e6f0;
}

.card-header h2 {
    margin: 0;
    font-size: 18px;
    color: #4e73df;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
}

.card-body {
    padding: 20px;
}

/* Sipariş Detayları */
.detail-row {
    display: flex;
    margin-bottom: 15px;
    border-bottom: 1px solid #e3e6f0;
    padding-bottom: 15px;
}

.detail-row:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

.detail-label {
    font-weight: 600;
    width: 150px;
    color: #5a5c69;
}

.detail-value {
    flex-grow: 1;
    color: #3a3b45;
    display: flex;
    align-items: center;
    gap: 8px;
}

/* Durum Badge'leri */
.status-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 13px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-weight: 500;
}

.status-preparing {
    background-color: #fff3cd;
    color: #856404;
}

.status-ready {
    background-color: #cce5ff;
    color: #004085;
}

.status-delivered {
    background-color: #d4edda;
    color: #155724;
}

/* Sipariş Ürünleri Tablosu */
.order-items-container {
    padding: 0;
}

.order-items-table {
    width: 100%;
    border-collapse: collapse;
}

.order-items-table th {
    background-color: #f8f9fc;
    color: #5a5c69;
    font-weight: 600;
    text-align: left;
    padding: 15px;
    border-bottom: 1px solid #e3e6f0;
    font-size: 14px;
}

.order-items-table td {
    padding: 15px;
    border-bottom: 1px solid #e3e6f0;
    vertical-align: middle;
    font-size: 14px;
}

.product-name {
    font-weight: 600;
    color: #3a3b45;
}

.product-quantity {
    text-align: center;
}

.product-price,
.product-total {
    text-align: right;
    font-weight: 500;
}

.product-total {
    color: #4e73df;
    font-weight: 700;
}

.currency {
    font-size: 12px;
    opacity: 0.8;
}

.order-total {
    text-align: right;
    padding: 15px 20px;
    border-top: 2px solid #e3e6f0;
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 10px;
}

.total-label {
    font-weight: 600;
    font-size: 18px;
    color: #5a5c69;
}

.total-value {
    font-weight: 700;
    font-size: 20px;
    color: #4e73df;
}

/* Aksyion Butonları */
.status-actions {
    display: flex;
    gap: 10px;
}

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 10px 20px;
    border-radius: 4px;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: background-color 0.2s;
}

.btn-warning {
    background-color: #f6c23e;
    color: white;
}

.btn-success {
    background-color: #1cc88a;
    color: white;
}

.btn-warning:hover {
    background-color: #e0ae37;
}

.btn-success:hover {
    background-color: #169c6e;
}

/* Responsive Ayarlar */
@media (max-width: 768px) {
    .header {
        flex-direction: column;
        text-align: center;
        gap: 15px;
    }
    
    .back-btn {
        align-self: center;
    }
    
    .detail-row {
        flex-direction: column;
        gap: 5px;
    }
    
    .detail-label {
        width: 100%;
    }
    
    .order-items-table {
        min-width: 600px;
    }
    
    .order-items-container {
        overflow-x: auto;
    }
}
</style>