<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            background-color: #333;
            color: white;
            width: 250px;
            padding: 20px 0;
        }
        .sidebar h2 {
            padding: 0 20px;
            margin-bottom: 30px;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .sidebar li {
            margin-bottom: 5px;
        }
        .sidebar a {
            display: block;
            padding: 10px 20px;
            color: #ddd;
            text-decoration: none;
            transition: all 0.3s;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #4CAF50;
            color: white;
        }
        .main-content {
            flex-grow: 1;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            background-color: white;
            padding: 15px 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .header h1 {
            margin: 0;
        }
        .user-info {
            display: flex;
            align-items: center;
        }
        .user-info a {
            margin-left: 15px;
            color: #f44336;
            text-decoration: none;
        }
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .card {
            background-color: white;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .card h3 {
            margin-top: 0;
            color: #333;
        }
        .card-value {
            font-size: 32px;
            font-weight: bold;
            margin: 10px 0;
            color: #4CAF50;
        }
        .recent-activity {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .activity-item {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .activity-item:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar Navigation -->
        <div class="sidebar">
            <h2>Admin Panel</h2>
            <ul>
                <li><a href="/admin" class="active">Dashboard</a></li>
                <li><a href="/admin/products">Ürünler</a></li>
                <li><a href="/admin/categories">Kategoriler</a></li>
                <li><a href="/admin/orders">Siparişler</a></li>
                <li><a href="/admin/logout">Çıkış</a></li>
            </ul>
        </div>
        
        <!-- Main Content Area -->
        <div class="main-content">
            <div class="header">
                <h1>Dashboard</h1>
                <div class="user-info">
                    <span>Hoşgeldiniz, Admin</span>
                    <a href="/admin/logout">Çıkış</a>
                </div>
            </div>
            
            <!-- Dashboard Summary Cards -->
            <div class="dashboard-cards">
                <div class="card">
                    <h3>Toplam Ürün</h3>
                    <div class="card-value"><?php echo \App\Models\ProductModel::count(); ?></div>
                </div>
                
                <div class="card">
                    <h3>Toplam Kategori</h3>
                    <div class="card-value"><?php echo \App\Models\CategoryModel::count(); ?></div>
                </div>
                
                <div class="card">
                    <h3>Aktif Siparişler</h3>
                    <div class="card-value"><?php 
                        echo \App\Models\OrderModel::count(\App\Models\OrderModel::STATUS_PREPARING) + 
                             \App\Models\OrderModel::count(\App\Models\OrderModel::STATUS_READY); 
                    ?></div>
                </div>
                
                <div class="card">
                    <h3>Tamamlanan Siparişler</h3>
                    <div class="card-value"><?php echo \App\Models\OrderModel::count(\App\Models\OrderModel::STATUS_DELIVERED); ?></div>
                </div>
            </div>
            
            <!-- Recent Activity Section -->
            <div class="recent-activity">
                <h2>Son Siparişler</h2>
                
                <?php 
                $orders = \App\Models\OrderModel::all();
                $count = 0;
                foreach ($orders as $order):
                    // Son 5 siparişi göster
                    if ($count++ >= 5) break;
                ?>
                <div class="activity-item">
                    <p>
                        <strong>Sipariş #<?php echo $order->id; ?></strong> - 
                        Masa <?php echo $order->table_id; ?> - 
                        Durum: <span style="color: 
                            <?php echo $order->status === \App\Models\OrderModel::STATUS_DELIVERED ? '#4CAF50' : 
                                  ($order->status === \App\Models\OrderModel::STATUS_READY ? '#FFC107' : '#FF5722'); ?>">
                            <?php echo htmlspecialchars($order->status); ?>
                        </span> - 
                        <?php echo htmlspecialchars($order->created_at); ?>
                    </p>
                </div>
                <?php endforeach; ?>
                
                <?php if ($count === 0): ?>
                <div class="activity-item">
                    <p>Henüz sipariş bulunmamaktadır.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>