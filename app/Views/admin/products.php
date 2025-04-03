<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ürün Yönetimi</title>
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
        .btn-danger {
            background-color: #f44336;
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
        .product-image {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 5px;
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
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar Navigation -->
        <div class="sidebar">
            <h2>Admin Panel</h2>
            <ul>
                <li><a href="/admin">Dashboard</a></li>
                <li><a href="/admin/products" class="active">Ürünler</a></li>
                <li><a href="/admin/categories">Kategoriler</a></li>
                <li><a href="/admin/orders">Siparişler</a></li>
                <li><a href="/admin/logout">Çıkış</a></li>
            </ul>
        </div>
        
        <!-- Main Content Area -->
        <div class="main-content">
            <div class="header">
                <h1>Ürün Yönetimi</h1>
                <a href="/admin/products/create" class="btn">Yeni Ürün Ekle</a>
            </div>
            
            <?php if (!empty($products)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Resim</th>
                            <th>Ürün Adı</th>
                            <th>Fiyat</th>
                            <th>Stok</th>
                            <th>Kategori</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <?php 
                                // Kategori adını al
                                $category = null;
                                if (!empty($product->category_id)) {
                                    $category = \App\Models\CategoryModel::find($product->category_id);
                                }
                            ?>
                            <tr>
                                <td><?php echo $product->id; ?></td>
                                <td>
                                    <?php if (!empty($product->image)): ?>
                                        <img src="<?php echo htmlspecialchars($product->image); ?>" alt="<?php echo htmlspecialchars($product->name); ?>" class="product-image">
                                    <?php else: ?>
                                        <div class="product-image" style="background-color: #eee; display: flex; align-items: center; justify-content: center; color: #999;">
                                            Resim Yok
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($product->name); ?></td>
                                <td><?php echo number_format($product->price, 2); ?> TL</td>
                                <td><?php echo $product->stock; ?></td>
                                <td><?php echo $category ? htmlspecialchars($category->name) : 'Kategorisiz'; ?></td>
                                <td class="actions">
                                    <a href="/admin/products/edit?id=<?php echo $product->id; ?>" class="btn btn-warning">Düzenle</a>
                                    <a href="/admin/products/delete?id=<?php echo $product->id; ?>" class="btn btn-danger" onclick="return confirm('Bu ürünü silmek istediğinize emin misiniz?')">Sil</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty-message">
                    <p>Henüz hiç ürün eklenmemiş.</p>
                    <a href="/admin/products/create" class="btn">Hemen Ürün Ekle</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
