<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($category) ? 'Kategori Düzenle' : 'Yeni Kategori Ekle'; ?></title>
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
        input[type="text"] {
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
                <li><a href="/admin/categories" class="active">Kategoriler</a></li>
                <li><a href="/admin/orders">Siparişler</a></li>
                <li><a href="/admin/logout">Çıkış</a></li>
            </ul>
        </div>
        
        <!-- Main Content Area -->
        <div class="main-content">
            <div class="header">
                <h1><?php echo isset($category) ? 'Kategori Düzenle' : 'Yeni Kategori Ekle'; ?></h1>
            </div>
            
            <div class="form-container">
                <?php if (isset($error)): ?>
                    <div class="error"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form action="<?php echo isset($category) ? "/admin/categories/edit?id={$category->id}" : "/admin/categories/create"; ?>" 
                      method="POST">
                    
                    <div class="form-group">
                        <label for="name">Kategori Adı</label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="<?php echo isset($category) ? htmlspecialchars($category->name) : ''; ?>" 
                               required>
                    </div>
                    
                    <div class="form-footer">
                        <a href="/admin/categories" class="btn btn-secondary">İptal</a>
                        <button type="submit" class="btn">Kaydet</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>