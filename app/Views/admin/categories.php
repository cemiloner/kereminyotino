<div class="categories-header">
    <h1><i class="fas fa-tags"></i> Kategori Yönetimi</h1>
    <a href="/admin/categories/create" class="add-category-btn"><i class="fas fa-plus-circle"></i> Yeni Kategori Ekle</a>
</div>

<?php if (!empty($categories)): ?>
    <div class="categories-container">
        <div class="categories-table-container">
            <table class="categories-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kategori Adı</th>
                        <th>Ürün Sayısı</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category): ?>
                        <?php 
                            // İlgili kategorideki ürün sayısını bul
                            $products = \App\Models\ProductModel::findByCategory($category->id);
                            $productCount = count($products);
                        ?>
                        <tr>
                            <td class="category-id">#<?php echo $category->id; ?></td>
                            <td class="category-name">
                                <div class="category-icon">
                                    <i class="fas fa-tag"></i>
                                </div>
                                <?php echo htmlspecialchars($category->name); ?>
                            </td>
                            <td>
                                <span class="product-count-badge">
                                    <i class="fas fa-box"></i> <?php echo $productCount; ?> ürün
                                </span>
                            </td>
                            <td class="actions">
                                <a href="/admin/categories/edit?id=<?php echo $category->id; ?>" class="btn btn-edit" title="Düzenle">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="/admin/categories/delete?id=<?php echo $category->id; ?>" class="btn btn-delete" onclick="return confirm('Bu kategoriyi silmek istediğinize emin misiniz? Bağlı ürünler kategorisiz kalacaktır.')" title="Sil">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php else: ?>
    <div class="empty-categories">
        <div class="empty-icon">
            <i class="fas fa-tags"></i>
        </div>
        <h3>Henüz hiç kategori bulunmamaktadır</h3>
        <p>Kategoriler ekleyerek ürünlerinizi düzenlemeye başlayın</p>
        <a href="/admin/categories/create" class="btn add-btn">
            <i class="fas fa-plus-circle"></i> Hemen Kategori Ekle
        </a>
    </div>
<?php endif; ?>

<!-- Font Awesome için CDN bağlantısı -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
/* Kategoriler Sayfası Stilleri */
.categories-header {
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

.categories-header h1 {
    font-size: 24px;
    margin: 0;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
}

.add-category-btn {
    background-color: rgba(255,255,255,0.2);
    color: white;
    text-decoration: none;
    padding: 10px 15px;
    border-radius: 6px;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: background-color 0.3s;
}

.add-category-btn:hover {
    background-color: rgba(255,255,255,0.3);
}

/* Kategori Tablosu */
.categories-container {
    margin-bottom: 30px;
}

.categories-table-container {
    background-color: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}

.categories-table {
    width: 100%;
    border-collapse: collapse;
}

.categories-table th {
    background-color: #f8f9fc;
    color: #5a5c69;
    font-weight: 600;
    text-align: left;
    padding: 15px;
    border-bottom: 2px solid #e3e6f0;
    font-size: 14px;
}

.categories-table td {
    padding: 15px;
    border-bottom: 1px solid #e3e6f0;
    vertical-align: middle;
    font-size: 14px;
}

.categories-table tr:hover {
    background-color: #f8f9fc;
}

.categories-table tr:last-child td {
    border-bottom: none;
}

/* Kategori Kimliği */
.category-id {
    font-weight: 600;
    color: #1cc88a;
}

/* Kategori Adı */
.category-name {
    font-weight: 600;
    color: #3a3b45;
    display: flex;
    align-items: center;
    gap: 12px;
}

.category-icon {
    background-color: rgba(28, 200, 138, 0.1);
    color: #1cc88a;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Ürün Sayacı */
.product-count-badge {
    background-color: #edf7ff;
    color: #4e73df;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-weight: 500;
}

/* İşlem Butonları */
.actions {
    display: flex;
    gap: 8px;
}

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    padding: 6px 12px;
    border-radius: 4px;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: background-color 0.2s;
}

.btn-edit {
    background-color: #f6c23e;
    color: white;
    width: 36px;
    height: 36px;
    border-radius: 4px;
}

.btn-edit:hover {
    background-color: #e0ae37;
}

.btn-delete {
    background-color: #e74a3b;
    color: white;
    width: 36px;
    height: 36px;
    border-radius: 4px;
}

.btn-delete:hover {
    background-color: #d52a1a;
}

/* Boş Kategoriler Mesajı */
.empty-categories {
    background-color: white;
    border-radius: 8px;
    padding: 60px 20px;
    text-align: center;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    margin-bottom: 30px;
}

.empty-categories .empty-icon {
    font-size: 60px;
    color: #1cc88a;
    margin-bottom: 20px;
    opacity: 0.7;
}

.empty-categories h3 {
    margin: 0 0 10px;
    font-size: 22px;
    color: #3a3b45;
    font-weight: 600;
}

.empty-categories p {
    margin: 0 0 25px;
    color: #858796;
    font-size: 16px;
}

.add-btn {
    background-color: #1cc88a;
    color: white;
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 6px;
}

.add-btn:hover {
    background-color: #169c6e;
}

/* Responsive Ayarlar */
@media (max-width: 768px) {
    .categories-table-container {
        overflow-x: auto;
    }
    
    .categories-table {
        min-width: 600px;
    }
    
    .categories-header {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
    }
    
    .add-category-btn {
        align-self: flex-end;
    }
}

@media (max-width: 576px) {
    .categories-header {
        align-items: center;
        text-align: center;
    }
    
    .add-category-btn {
        align-self: center;
    }
}
</style>