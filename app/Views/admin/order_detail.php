<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sipariş Detayı #<?php echo $order->id; ?></title>
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
            padding: 8px 15px;
            border-radius: 3px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }
        .btn-secondary {
            background-color: #6c757d;
        }
        .btn-warning {
            background-color: #ff9800;
        }
        .order-details {
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        .detail-row {
            display: flex;
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }
        .detail-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
        .detail-label {
            font-weight: bold;
            width: 150px;
            color: #555;
        }
        .detail-value {
            flex-grow: 1;
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
        .order-items {
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .order-items table {
            width: 100%;
            border-collapse: collapse;
        }
        .order-items th, .order-items td {
            text-align: left;
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
        }
        .order-items th {
            background-color: #f9f9f9;
            font-weight: bold;
        }
        .order-total {
            text-align: right;
            font-weight: bold;
            font-size: 18px;
            padding: 15px;
        }
        .actions-panel {
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            padding: 20px;
            margin-top: 20px;
        }
        .actions-title {
            font-weight: bold;
            margin-bottom: 15px;
            color: #333;
        }
        .status-actions {
            display: flex;
            gap: 10px;
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
                <h1>Sipariş Detayı #<?php echo $order->id; ?></h1>
                <a href="/admin/orders" class="btn btn-secondary">Geri Dön</a>
            </div>
            
            <!-- Order Summary -->
            <div class="order-details">
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
                            if ($order->status === 'hazır') {
                                $statusClass = 'status-ready';
                            } else if ($order->status === 'teslim edildi') {
                                $statusClass = 'status-delivered';
                            }
                        ?>
                        <span class="status <?php echo $statusClass; ?>">
                            <?php echo htmlspecialchars($order->status); ?>
                        </span>
                    </div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Sipariş Tarihi:</div>
                    <div class="detail-value"><?php echo date('d.m.Y H:i', strtotime($order->created_at)); ?></div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Son Güncelleme:</div>
                    <div class="detail-value"><?php echo date('d.m.Y H:i', strtotime($order->updated_at)); ?></div>
                </div>
            </div>
            
            <!-- Order Items -->
            <div class="order-items">
                <table>
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
                            <td><?php echo htmlspecialchars($product->name); ?></td>
                            <td><?php echo $quantity; ?></td>
                            <td><?php echo number_format($price, 2); ?> TL</td>
                            <td><?php echo number_format($itemTotal, 2); ?> TL</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
                <div class="order-total">
                    Toplam: <?php echo number_format($order->total_price ?? $totalAmount, 2); ?> TL
                </div>
            </div>
            
            <!-- Actions Panel -->
            <?php if ($order->status !== 'teslim edildi'): ?>
            <div class="actions-panel">
                <div class="actions-title">Sipariş Durumunu Güncelle</div>
                <div class="status-actions">
                    <form action="/admin/orders/update-status" method="POST">
                        <input type="hidden" name="order_id" value="<?php echo $order->id; ?>">
                        
                        <?php if ($order->status === 'hazırlanıyor'): ?>
                            <input type="hidden" name="status" value="hazır">
                            <button type="submit" class="btn btn-warning">Hazır Olarak İşaretle</button>
                        <?php elseif ($order->status === 'hazır'): ?>
                            <input type="hidden" name="status" value="teslim edildi">
                            <button type="submit" class="btn">Teslim Edildi Olarak İşaretle</button>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>