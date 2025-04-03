<div class="products-header">
    <h1><i class="fas fa-box"></i> Ürün Yönetimi</h1>
    <a href="/admin/products/create" class="add-product-btn"><i class="fas fa-plus-circle"></i> Yeni Ürün Ekle</a>
</div>

<?php if (!empty($products)): ?>
    <div class="products-container">
        <div class="products-table-container">
            <table class="products-table">
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
                            
                            // Stok durumuna göre sınıf belirle
                            $stockClass = 'stock-normal';
                            if ($product->stock <= 5) {
                                $stockClass = 'stock-low';
                            } elseif ($product->stock <= 0) {
                                $stockClass = 'stock-out';
                            }
                        ?>
                        <tr>
                            <td class="product-id">#<?= $product->id; ?></td>
                            <td class="product-img-cell">
                                <?php if (!empty($product->image)): ?>
                                    <div class="product-img-container">
                                        <img src="<?= htmlspecialchars($product->image); ?>" alt="<?= htmlspecialchars($product->name); ?>" class="product-image">
                                    </div>
                                <?php else: ?>
                                    <div class="product-img-placeholder">
                                        <i class="fas fa-camera"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="product-name"><?= htmlspecialchars($product->name); ?></td>
                            <td class="product-price"><?= number_format($product->price, 2); ?> <span class="currency">TL</span></td>
                            <td class="product-stock">
                                <span class="stock-badge <?= $stockClass; ?>">
                                    <?= $product->stock; ?> adet
                                </span>
                            </td>
                            <td>
                                <?php if ($category): ?>
                                    <span class="category-badge">
                                        <i class="fas fa-tag"></i> 
                                        <?= htmlspecialchars($category->name); ?>
                                    </span>
                                <?php else: ?>
                                    <span class="category-badge uncategorized">
                                        <i class="fas fa-question-circle"></i> Kategorisiz
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="actions">
                                <a href="/admin/products/edit?id=<?= $product->id; ?>" class="btn btn-edit" title="Düzenle">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="/admin/products/delete?id=<?= $product->id; ?>" class="btn btn-delete" onclick="return confirm('Bu ürünü silmek istediğinize emin misiniz?')" title="Sil">
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
    <div class="empty-products">
        <div class="empty-icon">
            <i class="fas fa-box-open"></i>
        </div>
        <h3>Henüz hiç ürün bulunmamaktadır</h3>
        <p>Yeni ürünler ekleyerek menünüzü oluşturmaya başlayın</p>
        <a href="/admin/products/create" class="btn add-btn">
            <i class="fas fa-plus-circle"></i> Hemen Ürün Ekle
        </a>
    </div>
<?php endif; ?>

<!-- Font Awesome için CDN bağlantısı -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
/* Ürünler Sayfası Stilleri */
.products-header {
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

.products-header h1 {
    font-size: 24px;
    margin: 0;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
}

.add-product-btn {
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

.add-product-btn:hover {
    background-color: rgba(255,255,255,0.3);
}

/* Ürün Tablosu */
.products-container {
    margin-bottom: 30px;
}

.products-table-container {
    background-color: white;
    border-radius: 8px;
    overflow: auto;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}

.products-table {
    width: 100%;
    border-collapse: collapse;
}

.products-table th {
    background-color: #f8f9fc;
    color: #5a5c69;
    font-weight: 600;
    text-align: left;
    padding: 15px;
    border-bottom: 2px solid #e3e6f0;
    font-size: 14px;
}

.products-table td {
    padding: 15px;
    border-bottom: 1px solid #e3e6f0;
    vertical-align: middle;
    font-size: 14px;
}

.products-table tr:hover {
    background-color: #f8f9fc;
}

.products-table tr:last-child td {
    border-bottom: none;
}

/* Ürün Kimliği */
.product-id {
    font-weight: 600;
    color: #4e73df;
}

/* Ürün Resmi */
.product-img-cell {
    width: 80px;
}

.product-img-container {
    width: 60px;
    height: 60px;
    border-radius: 6px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.product-img-placeholder {
    width: 60px;
    height: 60px;
    border-radius: 6px;
    background-color: #f8f9fc;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #aaa;
    font-size: 20px;
}

/* Ürün Adı */
.product-name {
    font-weight: 600;
    color: #3a3b45;
}

/* Ürün Fiyatı */
.product-price {
    font-weight: 700;
    color: #2e59d9;
}

.currency {
    font-weight: normal;
    font-size: 12px;
    opacity: 0.8;
}

/* Stok Durumu */
.stock-badge {
    padding: 6px 10px;
    border-radius: 20px;
    font-size: 12px;
    display: inline-block;
    font-weight: 500;
}

.stock-normal {
    background-color: #e8f5e9;
    color: #2e7d32;
}

.stock-low {
    background-color: #fff8e1;
    color: #f57c00;
}

.stock-out {
    background-color: #ffebee;
    color: #c62828;
}

/* Kategori */
.category-badge {
    background-color: #e3f2fd;
    color: #1565c0;
    padding: 6px 10px;
    border-radius: 20px;
    font-size: 12px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-weight: 500;
}

.category-badge.uncategorized {
    background-color: #f5f5f5;
    color: #757575;
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

/* Boş Ürünler Mesajı */
.empty-products {
    background-color: white;
    border-radius: 8px;
    padding: 60px 20px;
    text-align: center;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    margin-bottom: 30px;
}

.empty-products .empty-icon {
    font-size: 60px;
    color: #4e73df;
    margin-bottom: 20px;
    opacity: 0.7;
}

.empty-products h3 {
    margin: 0 0 10px;
    font-size: 22px;
    color: #3a3b45;
    font-weight: 600;
}

.empty-products p {
    margin: 0 0 25px;
    color: #858796;
    font-size: 16px;
}

.add-btn {
    background-color: #4e73df;
    color: white;
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 6px;
}

.add-btn:hover {
    background-color: #2e59d9;
}

/* Responsive Ayarlar */
@media (max-width: 992px) {
    .products-table-container {
        overflow-x: auto;
    }
    
    .products-table {
        min-width: 900px;
    }
    
    .products-header {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
    }
    
    .add-product-btn {
        align-self: flex-end;
    }
}

@media (max-width: 576px) {
    .products-header {
        align-items: center;
        text-align: center;
    }
    
    .add-product-btn {
        align-self: center;
    }
}
</style>
