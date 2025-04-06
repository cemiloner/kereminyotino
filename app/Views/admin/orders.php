<?php include __DIR__ . '/../layouts/admin.php'; ?>

<div class="orders-header">
    <h1>Sipariş Yönetimi</h1>
</div>

<!-- Filter Section -->
<div class="filter-container">
    <div class="filter-tabs">
        <button class="filter-tab active" data-status="all">
            <i class="fas fa-list-ul"></i> Tümü
            <span class="filter-count total-count">0</span>
        </button>
        <button class="filter-tab" data-status="new">
            <i class="fas fa-clock"></i> Yeni
            <span class="filter-count new-count">0</span>
        </button>
        <button class="filter-tab" data-status="preparing">
            <i class="fas fa-hourglass-half"></i> Hazırlanıyor
            <span class="filter-count preparing-count">0</span>
        </button>
        <button class="filter-tab" data-status="ready">
            <i class="fas fa-check"></i> Hazır
            <span class="filter-count ready-count">0</span>
        </button>
        <button class="filter-tab" data-status="delivered">
            <i class="fas fa-check-double"></i> Teslim Edildi
            <span class="filter-count delivered-count">0</span>
        </button>
    </div>
</div>

<div class="orders-table-container">
    <table class="orders-table">
        <thead>
            <tr>
                <th>Sipariş No</th>
                <th>Ürün</th>
                <th>Miktar</th>
                <th>Toplam</th>
                <th>Durum</th>
                <th>Tarih</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($orders)): ?>
                <?php foreach ($orders as $order): ?>
                    <tr data-status="<?= $order->status ?>">
                        <td class="order-id">#<?= $order->id ?></td>
                        <td><?= htmlspecialchars($order->product->name) ?></td>
                        <td><?= $order->quantity ?></td>
                        <td class="price-cell"><?= number_format($order->quantity * $order->product->price, 2) ?> TL</td>
                        <td>
                            <?php
                                $statusText = [
                                    'new' => 'Yeni',
                                    'preparing' => 'Hazırlanıyor',
                                    'ready' => 'Hazır',
                                    'delivered' => 'Teslim Edildi'
                                ];
                                $statusClass = [
                                    'new' => 'status-new',
                                    'preparing' => 'status-preparing',
                                    'ready' => 'status-ready',
                                    'delivered' => 'status-delivered'
                                ];
                            ?>
                            <span class="status-badge <?= $statusClass[$order->status] ?>">
                                <?= $statusText[$order->status] ?>
                            </span>
                        </td>
                        <td class="date-cell">
                            <i class="far fa-calendar-alt"></i>
                            <?= date('d.m.Y H:i', strtotime($order->created_at)) ?>
                        </td>
                        <td class="actions">
                            <?php if ($order->status === 'new'): ?>
                                <form action="/index.php/admin/orders/update-status" method="post" style="display:inline;">
                                    <input type="hidden" name="order_id" value="<?= $order->id ?>">
                                    <input type="hidden" name="status" value="preparing">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-hourglass-start"></i> Hazırlanıyor
                                    </button>
                                </form>
                            <?php elseif ($order->status === 'preparing'): ?>
                                <form action="/index.php/admin/orders/update-status" method="post" style="display:inline;">
                                    <input type="hidden" name="order_id" value="<?= $order->id ?>">
                                    <input type="hidden" name="status" value="ready">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-check"></i> Hazırlandı
                                    </button>
                                </form>
                            <?php elseif ($order->status === 'ready'): ?>
                                <form action="/index.php/admin/orders/update-status" method="post" style="display:inline;">
                                    <input type="hidden" name="order_id" value="<?= $order->id ?>">
                                    <input type="hidden" name="status" value="delivered">
                                    <button type="submit" class="btn btn-info">
                                        <i class="fas fa-check-double"></i> Teslim Edildi
                                    </button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="empty-message">Henüz sipariş bulunmamaktadır.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<style>
/* Siparişler Sayfası Stilleri */
.orders-header {
    background: linear-gradient(to right, #36b9cc, #1a8a98);
    color: white;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 25px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
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
    background: none;
    border: none;
    cursor: pointer;
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

.status-new {
    background-color: #eee;
    color: #555;
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

.btn-primary {
    background-color: #4e73df;
    color: white;
}

.btn-success {
    background-color: #1cc88a;
    color: white;
}

.btn-info {
    background-color: #36b9cc;
    color: white;
}

.btn-primary:hover { background-color: #2e59d9; }
.btn-success:hover { background-color: #169b6b; }
.btn-info:hover { background-color: #2a9faf; }

.empty-message {
    text-align: center;
    color: #858796;
    padding: 30px !important;
    font-style: italic;
}

/* Responsive Tasarım */
@media (max-width: 992px) {
    .filter-tabs {
        flex-wrap: wrap;
    }
    
    .filter-tab {
        flex: 1 0 33.333%;
    }
}

@media (max-width: 768px) {
    .orders-table-container {
        overflow-x: auto;
    }
    
    .orders-table {
        min-width: 800px;
    }
    
    .filter-tab {
        flex: 1 0 50%;
        padding: 10px;
    }
    
    .filter-tab i {
        font-size: 16px;
        margin-bottom: 5px;
    }
}

@media (max-width: 576px) {
    .filter-tab {
        flex: 1 0 100%;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sipariş sayılarını güncelle
    function updateOrderCounts() {
        const orders = document.querySelectorAll('.orders-table tbody tr[data-status]');
        let counts = {
            'all': 0,
            'new': 0,
            'preparing': 0,
            'ready': 0,
            'delivered': 0
        };
        
        orders.forEach(order => {
            const status = order.dataset.status;
            counts[status]++;
            counts['all']++;
        });
        
        // Sayıları güncelle
        document.querySelector('.total-count').textContent = counts['all'];
        document.querySelector('.new-count').textContent = counts['new'];
        document.querySelector('.preparing-count').textContent = counts['preparing'];
        document.querySelector('.ready-count').textContent = counts['ready'];
        document.querySelector('.delivered-count').textContent = counts['delivered'];
    }
    
    // Filtreleme işlevi
    function filterOrders(status) {
        const orders = document.querySelectorAll('.orders-table tbody tr[data-status]');
        
        orders.forEach(order => {
            if (status === 'all' || order.dataset.status === status) {
                order.style.display = '';
            } else {
                order.style.display = 'none';
            }
        });
    }
    
    // Tab tıklama olayları
    document.querySelectorAll('.filter-tab').forEach(tab => {
        tab.addEventListener('click', () => {
            // Aktif tab'ı güncelle
            document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            
            // Siparişleri filtrele
            filterOrders(tab.dataset.status);
        });
    });
    
    // Sayfa yüklendiğinde sayıları güncelle
    updateOrderCounts();
});
</script>