<div class="header">
    <h1><?php echo isset($product) ? 'Ürün Düzenle' : 'Yeni Ürün Ekle'; ?></h1>
    <a href="/admin/products" class="back-btn"><i class="fas fa-arrow-left"></i> Ürünlere Dön</a>
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

<!-- Font Awesome için CDN bağlantısı -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
/* Form Stilleri */
.header {
    background: linear-gradient(to right, #4e73df, #224abe);
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

input[type="text"],
input[type="number"],
select,
textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid #e3e6f0;
    border-radius: 4px;
    font-size: 15px;
    box-sizing: border-box;
    transition: border-color 0.3s;
}

input[type="text"]:focus,
input[type="number"]:focus,
select:focus,
textarea:focus {
    border-color: #4e73df;
    outline: none;
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
}

input[type="file"] {
    border: 1px solid #e3e6f0;
    padding: 10px;
    border-radius: 4px;
    width: 100%;
    box-sizing: border-box;
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
    background-color: #4e73df;
    color: white;
}

.btn:hover {
    background-color: #2e59d9;
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

.current-image {
    max-width: 200px;
    max-height: 200px;
    margin-top: 10px;
    border: 1px solid #e3e6f0;
    border-radius: 4px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
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