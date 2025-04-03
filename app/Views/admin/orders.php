<div class="orders-header">
    <h1>Sipariş Yönetimi</h1>
</div>

<!-- Filter Section -->
<div class="filter-container">
    <div class="filter-tabs">
        <a href="/admin/orders" class="filter-tab <?php echo empty($_GET['status']) ? 'active' : ''; ?>">
            <i class="fas fa-list-ul"></i> Tümü
            <span class="filter-count"><?php echo count(\App\Models\OrderModel::all()); ?></span>
        </a>
        <a href="/admin/orders?status=hazırlanıyor" class="filter-tab <?php echo isset($_GET['status']) && $_GET['status'] === 'hazırlanıyor' ? 'active' : ''; ?>">
            <i class="fas fa-hourglass-half"></i> Hazırlanıyor
            <span class="filter-count"><?php echo \App\Models\OrderModel::count(\App\Models\OrderModel::STATUS_PREPARING); ?></span>
        </a>
        <a href="/admin/orders?status=hazır" class="filter-tab <?php echo isset($_GET['status']) && $_GET['status'] === 'hazır' ? 'active' : ''; ?>">
            <i class="fas fa-check"></i> Hazır
            <span class="filter-count"><?php echo \App\Models\OrderModel::count(\App\Models\OrderModel::STATUS_READY); ?></span>
        </a>
        <a href="/admin/orders?status=teslim edildi" class="filter-tab <?php echo isset($_GET['status']) && $_GET['status'] === 'teslim edildi' ? 'active' : ''; ?>">
            <i class="fas fa-check-double"></i> Teslim Edildi
            <span class="filter-count"><?php echo \App\Models\OrderModel::count(\App\Models\OrderModel::STATUS_DELIVERED); ?></span>
        </a>
    </div>
</div>

<?php if (!empty($orders)): ?>
    <div class="orders-table-container">
        <table class="orders-table">
            <thead>
                <tr>
                    <th>Sipariş No</th>
                    <th>Masa No</th>
                    <th>Ürünler</th>
                    <th>Toplam</th>
                    <th>Durum</th>
                    <th>Tarih</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <?php 
                        // Decode the products JSON
                        $products = json_decode($order->products, true) ?? [];
                        $productCount = count($products);
                    ?>
                    <tr>
                        <td class="order-id">#<?php echo $order->id; ?></td>
                        <td>Masa <?php echo $order->table_id; ?></td>
                        <td>
                            <?php if ($productCount > 0): ?>
                                <span class="product-count-badge"><?php echo $productCount; ?> ürün</span>
                            <?php else: ?>
                                <span class="empty-badge">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="price-cell"><?php echo number_format($order->total_price, 2); ?> TL</td>
                        <td>
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
                        </td>
                        <td class="date-cell">
                            <i class="far fa-calendar-alt"></i>
                            <?php echo date('d.m.Y H:i', strtotime($order->created_at)); ?>
                        </td>
                        <td class="actions">
                            <a href="/admin/orders/detail?id=<?php echo $order->id; ?>" class="btn btn-info">
                                <i class="fas fa-eye"></i> Detay
                            </a>
                            
                            <?php if ($order->status !== 'teslim edildi'): ?>
                                <form action="/admin/orders/update-status" method="POST" style="display:inline-block;">
                                    <input type="hidden" name="order_id" value="<?php echo $order->id; ?>">
                                    
                                    <?php if ($order->status === 'hazırlanıyor'): ?>
                                        <input type="hidden" name="status" value="hazır">
                                        <button type="submit" class="btn btn-warning">
                                            <i class="fas fa-check"></i> Hazır
                                        </button>
                                    <?php elseif ($order->status === 'hazır'): ?>
                                        <input type="hidden" name="status" value="teslim edildi">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-check-double"></i> Teslim Et
                                        </button>
                                    <?php endif; ?>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="empty-orders">
        <div class="empty-icon">
            <i class="fas fa-shopping-bag"></i>
        </div>
        <p>Henüz hiç sipariş bulunmamaktadır.</p>
    </div>
<?php endif; ?>

<!-- Font Awesome için CDN bağlantısı -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
/* Siparişler Sayfası Stilleri */
.orders-header {
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

.orders-header h1 {
    font-size: 24px;
    margin: 0;
    font-weight: 600;
}

/* Filtre Tab Tasarımı */
.filter-container {
    margin-bottom: 25px;
}

.filter-tabs {
    display: flex;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    overflow: hidden;
}

.filter-tab {
    flex: 1;
    text-align: center;
    padding: 15px 10px;
    color: #5a5c69;
    text-decoration: none;
    font-weight: 500;
    border-bottom: 3px solid transparent;
    transition: all 0.3s;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.filter-tab:hover {
    background-color: #f8f9fc;
    color: #4e73df;
}

.filter-tab.active {
    background-color: #f8f9fc;
    color: #4e73df;
    border-bottom-color: #4e73df;
}

.filter-tab i {
    font-size: 18px;
    margin-bottom: 8px;
}

.filter-count {
    background-color: #e0e3eb;
    color: #5a5c69;
    border-radius: 20px;
    padding: 2px 8px;
    font-size: 12px;
    margin-top: 5px;
}

.filter-tab.active .filter-count {
    background-color: #4e73df;
    color: white;
}

/* Sipariş Tablosu */
.orders-table-container {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    overflow: hidden;
    margin-bottom: 25px;
}

.orders-table {
    width: 100%;
    border-collapse: collapse;
}

.orders-table th {
    background-color: #f8f9fc;
    color: #5a5c69;
    font-weight: 600;
    text-align: left;
    padding: 15px;
    border-bottom: 2px solid #e3e6f0;
    font-size: 14px;
}

.orders-table td {
    padding: 15px;
    border-bottom: 1px solid #e3e6f0;
    vertical-align: middle;
    font-size: 14px;
}

.orders-table tr:last-child td {
    border-bottom: none;
}

.orders-table tr:hover {
    background-color: #f8f9fc;
}

.order-id {
    font-weight: 600;
    color: #3a3b45;
}

.product-count-badge {
    background-color: #e0e3eb;
    color: #5a5c69;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 13px;
}

.price-cell {
    font-weight: 600;
    color: #3a3b45;
}

.date-cell {
    color: #858796;
    font-size: 13px;
    display: flex;
    align-items: center;
    gap: 5px;
}

/* Durum Badge'leri */
.status-badge {
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 12px;
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

/* Butonlar */
.btn {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 6px 12px;
    border-radius: 4px;
    font-size: 13px;
    font-weight: 500;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: background-color 0.2s;
}

.btn-info {
    background-color: #36b9cc;
    color: white;
}

.btn-warning {
    background-color: #f6c23e;
    color: #fff;
}

.btn-success {
    background-color: #1cc88a;
    color: white;
}

.btn-info:hover {
    background-color: #2c9faf;
}

.btn-warning:hover {
    background-color: #e0ae37;
}

.btn-success:hover {
    background-color: #18a97c;
}

/* Aksiyon Düğmeleri */
.actions {
    display: flex;
    gap: 5px;
}

/* Siparişler Boş Durumu */
.empty-orders {
    background-color: white;
    border-radius: 8px;
    padding: 50px 20px;
    text-align: center;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    color: #858796;
}

.empty-orders .empty-icon {
    font-size: 48px;
    margin-bottom: 15px;
    opacity: 0.5;
}

.empty-orders p {
    font-size: 16px;
    margin: 0;
}

/* Responsive Ayarlar */
@media (max-width: 992px) {
    .filter-tabs {
        flex-wrap: wrap;
    }
    
    .filter-tab {
        flex: 1 0 50%;
        padding: 10px;
    }
}

@media (max-width: 768px) {
    .orders-table-container {
        overflow-x: auto;
    }
    
    .orders-table {
        min-width: 800px;
    }
}
</style>