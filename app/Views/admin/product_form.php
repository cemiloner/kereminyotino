<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($product) ? 'Ürün Düzenle' : 'Yeni Ürün Ekle'; ?></title>
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
        .form-container {
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            padding: 25px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        input[type="text"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 3px;
            font-size: 16px;
            box-sizing: border-box;
        }
        .btn {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border-radius: 3px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        .btn-secondary {
            background-color: #6c757d;
            margin-right: 10px;
        }
        .error {
            color: #f44336;
            margin-top: 5px;
        }
        .form-footer {
            display: flex;
            justify-content: flex-start;
            margin-top: 20px;
        }
        .current-image {
            max-width: 200px;
            max-height: 200px;
            margin-top: 10px;
            border: 1px solid #ddd;
            border-radius: 3px;
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
                <h1><?php echo isset($product) ? 'Ürün Düzenle' : 'Yeni Ürün Ekle'; ?></h1>
            </div>
            
            <div class="form-container">
                <?php if (isset($error)): ?>
                    <div class="error"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form action="<?php echo isset($product) ? "/admin/products/edit?id={$product->id}" : "/admin/products/create"; ?>" 
                      method="POST" 
                      enctype="multipart/form-data">
                    
                    <div class="form-group">
                        <label for="name">Ürün Adı</label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="<?php echo isset($product) ? htmlspecialchars($product->name) : ''; ?>" 
                               required>
                    </div>
                    
                    <div class="form-group">
                        <label for="price">Fiyat (TL)</label>
                        <input type="number" 
                               id="price" 
                               name="price" 
                               step="0.01" 
                               value="<?php echo isset($product) ? $product->price : ''; ?>" 
                               required>
                    </div>
                    
                    <div class="form-group">
                        <label for="stock">Stok Miktarı</label>
                        <input type="number" 
                               id="stock" 
                               name="stock" 
                               value="<?php echo isset($product) ? $product->stock : ''; ?>" 
                               required>
                    </div>
                    
                    <div class="form-group">
                        <label for="category_id">Kategori</label>
                        <select id="category_id" name="category_id">
                            <option value="">Kategorisiz</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category->id; ?>" 
                                    <?php echo (isset($product) && $product->category_id == $category->id) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($category->name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="image">Ürün Görseli</label>
                        <?php if (isset($product) && !empty($product->image)): ?>
                            <div>
                                <p>Mevcut görsel:</p>
                                <img src="<?php echo $product->image; ?>" alt="Mevcut görsel" class="current-image">
                            </div>
                            <p><small>Yeni bir görsel yüklerseniz, mevcut görsel değiştirilecektir.</small></p>
                        <?php endif; ?>
                        <input type="file" id="image" name="image" accept="image/*">
                    </div>
                    
                    <div class="form-footer">
                        <a href="/admin/products" class="btn btn-secondary">İptal</a>
                        <button type="submit" class="btn">Kaydet</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>