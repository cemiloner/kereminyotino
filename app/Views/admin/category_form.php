<div class="header">
    <h1><?php echo isset($category) ? 'Kategori Düzenle' : 'Yeni Kategori Ekle'; ?></h1>
    <a href="/admin/categories" class="back-btn"><i class="fas fa-arrow-left"></i> Kategorilere Dön</a>
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

<!-- Font Awesome için CDN bağlantısı -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
/* Form Stilleri */
.header {
    background: linear-gradient(to right, #1cc88a, #169c6e);
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

.form-container {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    padding: 25px;
    margin-bottom: 30px;
}

.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #3a3b45;
    font-size: 14px;
}

input[type="text"] {
    width: 100%;
    padding: 12px;
    border: 1px solid #e3e6f0;
    border-radius: 4px;
    font-size: 15px;
    box-sizing: border-box;
    transition: border-color 0.3s;
}

input[type="text"]:focus {
    border-color: #1cc88a;
    outline: none;
    box-shadow: 0 0 0 0.2rem rgba(28, 200, 138, 0.25);
}

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    padding: 10px 20px;
    border-radius: 4px;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: background-color 0.2s;
}

.btn-secondary {
    background-color: #6c757d;
    color: white;
    margin-right: 10px;
}

.btn-secondary:hover {
    background-color: #5a6268;
}

.btn {
    background-color: #1cc88a;
    color: white;
}

.btn:hover {
    background-color: #169c6e;
}

.error {
    background-color: #f8d7da;
    color: #721c24;
    padding: 12px;
    border-radius: 4px;
    margin-bottom: 20px;
    border-left: 4px solid #f5c6cb;
}

.form-footer {
    display: flex;
    justify-content: flex-start;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #e3e6f0;
}

@media (max-width: 768px) {
    .header {
        flex-direction: column;
        text-align: center;
        gap: 15px;
    }
    
    .back-btn {
        align-self: center;
    }
}
</style>