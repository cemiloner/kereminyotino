<div class="dashboard-header">
    <h1>Yönetim Paneli</h1>
    <div class="user-actions">
        <span class="user-welcome"><i class="fas fa-user-circle"></i> Admin</span>
        <a href="/admin/logout" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Çıkış</a>
    </div>
</div>

<!-- Dashboard Summary Cards -->
<div class="dashboard-stats">
    <div class="stat-card product-card">
        <div class="stat-icon">
            <i class="fas fa-box"></i>
        </div>
        <div class="stat-content">
            <h3>Toplam Ürün</h3>
            <div class="stat-value"><?php echo \App\Models\ProductModel::count(); ?></div>
            <div class="stat-label">kayıtlı ürün</div>
        </div>
    </div>
    
    <div class="stat-card category-card">
        <div class="stat-icon">
            <i class="fas fa-tags"></i>
        </div>
        <div class="stat-content">
            <h3>Toplam Kategori</h3>
            <div class="stat-value"><?php echo \App\Models\CategoryModel::count(); ?></div>
            <div class="stat-label">kayıtlı kategori</div>
        </div>
    </div>
    
    <div class="stat-card active-order-card">
        <div class="stat-icon">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-content">
            <h3>Aktif Siparişler</h3>
            <div class="stat-value"><?php 
                echo \App\Models\OrderModel::count(\App\Models\OrderModel::STATUS_PREPARING) + 
                     \App\Models\OrderModel::count(\App\Models\OrderModel::STATUS_READY); 
            ?></div>
            <div class="stat-label">işlem bekleyen sipariş</div>
        </div>
    </div>
    
    <div class="stat-card completed-order-card">
        <div class="stat-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-content">
            <h3>Tamamlanan Siparişler</h3>
            <div class="stat-value"><?php echo \App\Models\OrderModel::count(\App\Models\OrderModel::STATUS_DELIVERED); ?></div>
            <div class="stat-label">teslim edilmiş</div>
        </div>
    </div>
</div>

<!-- Recent Activity Section -->
<div class="recent-activity-section">
    <div class="section-header">
        <h2><i class="fas fa-history"></i> Son Siparişler</h2>
        <a href="/admin/orders" class="view-all-btn">Tümünü Görüntüle</a>
    </div>
    
    <div class="activity-list">
        <?php 
        $orders = \App\Models\OrderModel::all();
        $count = 0;
        foreach ($orders as $order):
            // Son 5 siparişi göster
            if ($count++ >= 5) break;
        ?>
        <div class="activity-card">
            <div class="activity-info">
                <div class="order-id">#<?php echo $order->id; ?></div>
                <div class="order-details">
                    <span class="table-badge">Masa <?php echo $order->table_id; ?></span>
                    <?php
                        $statusClass = 'status-preparing';
                        $statusIcon = 'fa-hourglass-half';
                        if ($order->status === \App\Models\OrderModel::STATUS_READY) {
                            $statusClass = 'status-ready';
                            $statusIcon = 'fa-check';
                        } else if ($order->status === \App\Models\OrderModel::STATUS_DELIVERED) {
                            $statusClass = 'status-delivered';
                            $statusIcon = 'fa-check-double';
                        }
                    ?>
                    <span class="status-badge <?php echo $statusClass; ?>">
                        <i class="fas <?php echo $statusIcon; ?>"></i>
                        <?php echo htmlspecialchars($order->status); ?>
                    </span>
                </div>
                <div class="order-date">
                    <i class="far fa-calendar-alt"></i>
                    <?php echo date('d.m.Y H:i', strtotime($order->created_at)); ?>
                </div>
            </div>
            <a href="/admin/orders/detail?id=<?php echo $order->id; ?>" class="view-order-btn">
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <?php endforeach; ?>
        
        <?php if ($count === 0): ?>
        <div class="empty-activity">
            <i class="fas fa-shopping-bag empty-icon"></i>
            <p>Henüz sipariş bulunmamaktadır.</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Font Awesome için CDN bağlantısı -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
/* Dashboard Sayfası Stilleri */
.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: linear-gradient(to right, #4e73df, #224abe);
    color: white;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 25px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.dashboard-header h1 {
    font-size: 24px;
    margin: 0;
    font-weight: 600;
}

.user-actions {
    display: flex;
    align-items: center;
    gap: 15px;
}

.user-welcome {
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 5px;
}

.logout-btn {
    background-color: rgba(255,255,255,0.2);
    color: white;
    text-decoration: none;
    padding: 8px 15px;
    border-radius: 20px;
    transition: background-color 0.3s;
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 14px;
}

.logout-btn:hover {
    background-color: rgba(255,255,255,0.3);
}

/* İstatistik Kartları */
.dashboard-stats {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background-color: white;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    display: flex;
    align-items: center;
    transition: transform 0.2s, box-shadow 0.2s;
    position: relative;
    overflow: hidden;
    border-left: 4px solid #4e73df;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 7px 15px rgba(0,0,0,0.1);
}

.product-card {
    border-left-color: #4e73df;
}

.category-card {
    border-left-color: #1cc88a;
}

.active-order-card {
    border-left-color: #f6c23e;
}

.completed-order-card {
    border-left-color: #36b9cc;
}

.stat-icon {
    font-size: 40px;
    color: #f8f9fc;
    background-color: rgba(78, 115, 223, 0.1);
    height: 64px;
    width: 64px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 20px;
}

.product-card .stat-icon {
    color: #4e73df;
}

.category-card .stat-icon {
    color: #1cc88a;
    background-color: rgba(28, 200, 138, 0.1);
}

.active-order-card .stat-icon {
    color: #f6c23e;
    background-color: rgba(246, 194, 62, 0.1);
}

.completed-order-card .stat-icon {
    color: #36b9cc;
    background-color: rgba(54, 185, 204, 0.1);
}

.stat-content {
    flex: 1;
}

.stat-content h3 {
    font-size: 14px;
    margin: 0 0 10px;
    color: #5a5c69;
    font-weight: 600;
    text-transform: uppercase;
}

.stat-value {
    font-size: 32px;
    font-weight: 700;
    color: #3a3b45;
    margin-bottom: 5px;
}

.stat-label {
    font-size: 13px;
    color: #858796;
}

/* Son Aktiviteler */
.recent-activity-section {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    padding: 20px;
    margin-bottom: 30px;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    border-bottom: 1px solid #e3e6f0;
    padding-bottom: 15px;
}

.section-header h2 {
    margin: 0;
    font-size: 18px;
    color: #4e73df;
    font-weight: 600;
    display: flex;
    align-items: center;
}

.section-header h2 i {
    margin-right: 8px;
}

.view-all-btn {
    color: #4e73df;
    font-size: 14px;
    text-decoration: none;
    display: flex;
    align-items: center;
}

.view-all-btn:hover {
    text-decoration: underline;
}

.activity-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.activity-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px;
    border-radius: 6px;
    background-color: #f8f9fc;
    transition: background-color 0.2s;
}

.activity-card:hover {
    background-color: #eef0f8;
}

.activity-info {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 15px;
}

.order-id {
    font-size: 18px;
    font-weight: 600;
    color: #3a3b45;
}

.table-badge {
    background-color: #e0e3eb;
    color: #5a5c69;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 13px;
}

.order-details {
    display: flex;
    align-items: center;
    gap: 8px;
}

.status-badge {
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 12px;
    display: flex;
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

.order-date {
    color: #858796;
    font-size: 13px;
    display: flex;
    align-items: center;
    gap: 5px;
}

.view-order-btn {
    color: #4e73df;
    background-color: #eaedfa;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background-color 0.2s;
    text-decoration: none;
}

.view-order-btn:hover {
    background-color: #d4dafd;
    color: #2e50bc;
}

.empty-activity {
    text-align: center;
    padding: 30px 0;
    color: #858796;
}

.empty-icon {
    font-size: 48px;
    margin-bottom: 10px;
    opacity: 0.5;
}

/* Responsive Ayarlar */
@media (max-width: 768px) {
    .dashboard-stats {
        grid-template-columns: 1fr;
    }

    .activity-info {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }
    
    .dashboard-header {
        flex-direction: column;
        text-align: center;
        gap: 15px;
    }
}
</style>