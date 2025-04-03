<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sipariş Yönetimi</title>
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
        .btn {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border-radius: 3px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }
        .btn-info {
            background-color: #17a2b8;
        }
        .btn-warning {
            background-color: #ff9800;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            border-radius: 5px;
        }
        th, td {
            text-align: left;
            padding: 15px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .empty-message {
            text-align: center;
            padding: 20px;
            background-color: white;
            border-radius: 5px;
            margin-top: 20px;
        }
        .actions {
            display: flex;
            gap: 5px;
        }
        .status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            display: inline-block;
            text-align: center;
            min-width: 80px;
        }
        .status-preparing {
            background-color: #ffecb3;
            color: #e65100;
        }
        .status-ready {
            background-color: #b3e5fc;
            color: #01579b;
        }
        .status-delivered {
            background-color: #c8e6c9;
            color: #1b5e20;
        }
        .filters {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        .filter-btn {
            background-color: white;
            border: 1px solid #ddd;
            padding: 8px 15px;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .filter-btn:hover, .filter-btn.active {
            background-color: #4CAF50;
            color: white;
            border-color: #4CAF50;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar Navigation -->
        <div class="sidebar">
            <h2>Admin Panel</h2>
            <ul>
                <li><a href="/admin">Dashboard</a></li>
                <li><a href="/admin/products">Ürünler</a></li>
                <li><a href="/admin/categories">Kategoriler</a></li>
                <li><a href="/admin/orders" class="active">Siparişler</a></li>
                <li><a href="/admin/logout">Çıkış</a></li>
            </ul>
        </div>
        
        <!-- Main Content Area -->
        <div class="main-content">
            <div class="header">
                <h1>Sipariş Yönetimi</h1>
            </div>
            
            <!-- Filter Buttons -->
            <div class="filters">
                <a href="/admin/orders" class="filter-btn active">Tümü</a>
                <a href="/admin/orders?status=hazırlanıyor" class="filter-btn">Hazırlanıyor</a>
                <a href="/admin/orders?status=hazır" class="filter-btn">Hazır</a>
                <a href="/admin/orders?status=teslim edildi" class="filter-btn">Teslim Edildi</a>
            </div>
            
            <?php if (!empty($orders)): ?>
                <table>
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
                                <td>#<?php echo $order->id; ?></td>
                                <td>Masa <?php echo $order->table_id; ?></td>
                                <td>
                                    <?php if ($productCount > 0): ?>
                                        <?php echo $productCount; ?> ürün
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td><?php echo number_format($order->total_price, 2); ?> TL</td>
                                <td>
                                    <?php
                                        $statusClass = 'status-preparing';
                                        if ($order->status === 'hazır') {
                                            $statusClass = 'status-ready';
                                        } else if ($order->status === 'teslim edildi') {
                                            $statusClass = 'status-delivered';
                                        }
                                    ?>
                                    <span class="status <?php echo $statusClass; ?>">
                                        <?php echo htmlspecialchars($order->status); ?>
                                    </span>
                                </td>
                                <td><?php echo date('d.m.Y H:i', strtotime($order->created_at)); ?></td>
                                <td class="actions">
                                    <a href="/admin/orders/detail?id=<?php echo $order->id; ?>" class="btn btn-info">Detay</a>
                                    
                                    <?php if ($order->status !== 'teslim edildi'): ?>
                                        <form action="/admin/orders/update-status" method="POST" style="display:inline-block;">
                                            <input type="hidden" name="order_id" value="<?php echo $order->id; ?>">
                                            
                                            <?php if ($order->status === 'hazırlanıyor'): ?>
                                                <input type="hidden" name="status" value="hazır">
                                                <button type="submit" class="btn btn-warning">Hazır</button>
                                            <?php elseif ($order->status === 'hazır'): ?>
                                                <input type="hidden" name="status" value="teslim edildi">
                                                <button type="submit" class="btn">Teslim Edildi</button>
                                            <?php endif; ?>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty-message">
                    <p>Henüz hiç sipariş bulunmamaktadır.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>