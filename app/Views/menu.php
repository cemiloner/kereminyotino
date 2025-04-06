<?php include __DIR__ . '/layouts/customer.php'; ?>

<div class="menu-container">
    <h1>Menümüz</h1>

    <div class="categories">
        <?php foreach ($categories as $category): ?>
            <div class="category">
                <h2><?= htmlspecialchars($category->name) ?></h2>
                <div class="products">
                    <?php 
                    $categoryProducts = array_filter($products, function($product) use ($category) {
                        return $product->category_id == $category->id;
                    });
                    foreach ($categoryProducts as $product): 
                    ?>
                        <div class="product-card">
                            <?php if (!empty($product->image)): ?>
                                <img src="<?= htmlspecialchars($product->image) ?>" alt="<?= htmlspecialchars($product->name) ?>" class="product-image">
                            <?php endif; ?>
                            <div class="product-info">
                                <h3><?= htmlspecialchars($product->name) ?></h3>
                                <p class="price"><?= number_format($product->price, 2) ?> TL</p>
                                <form action="/order" method="post" class="order-form">
                                    <input type="hidden" name="product_id" value="<?= $product->id ?>">
                                    <div class="quantity-control">
                                        <button type="button" class="quantity-btn minus">-</button>
                                        <input type="number" name="quantity" value="1" min="1" max="<?= $product->stock ?>" class="quantity-input">
                                        <button type="button" class="quantity-btn plus">+</button>
                                    </div>
                                    <button type="submit" class="order-btn">Sipariş Ver</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
:root {
    --primary-color: #4CAF50;
    --primary-dark: #45a049;
    --text-color: #333;
    --text-light: #666;
    --bg-color: #f4f4f4;
    --white: #fff;
    --shadow: 0 2px 10px rgba(0,0,0,0.1);
    --border-radius: 10px;
    --transition: all 0.3s ease;
}

.menu-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 1rem;
}

.menu-container h1 {
    text-align: center;
    color: var(--text-color);
    margin-bottom: 1.5rem;
    font-size: clamp(1.8rem, 4vw, 2.2rem);
    position: relative;
    padding-bottom: 0.5rem;
}

.menu-container h1::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 100px;
    height: 3px;
    background-color: var(--primary-color);
    border-radius: 3px;
}

.categories {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.category h2 {
    color: var(--text-color);
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid var(--primary-color);
    font-size: 1.5rem;
    position: relative;
}

.products {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1.5rem;
}

.product-card {
    background: var(--white);
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: var(--shadow);
    transition: var(--transition);
    display: flex;
    flex-direction: column;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.product-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
    transition: var(--transition);
}

.product-card:hover .product-image {
    transform: scale(1.05);
}

.product-info {
    padding: 1.2rem;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.product-info h3 {
    margin: 0 0 0.5rem;
    color: var(--text-color);
    font-size: 1.2rem;
}

.price {
    color: var(--primary-color);
    font-size: 1.1rem;
    font-weight: bold;
    margin: 0.5rem 0;
}

.order-form {
    margin-top: auto;
}

.quantity-control {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.8rem;
}

.quantity-btn {
    background: #f0f0f0;
    border: none;
    width: 30px;
    height: 30px;
    border-radius: var(--border-radius);
    cursor: pointer;
    font-size: 1.1rem;
    transition: var(--transition);
    display: flex;
    align-items: center;
    justify-content: center;
}

.quantity-btn:hover {
    background: #e0e0e0;
}

.quantity-input {
    width: 50px;
    text-align: center;
    border: 1px solid #ddd;
    border-radius: var(--border-radius);
    padding: 0.5rem;
    font-size: 1rem;
}

.order-btn {
    width: 100%;
    padding: 0.8rem;
    background: var(--primary-color);
    color: var(--white);
    border: none;
    border-radius: var(--border-radius);
    cursor: pointer;
    transition: var(--transition);
    font-size: 1rem;
    font-weight: 500;
}

.order-btn:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
}

/* Tablet için medya sorguları */
@media (max-width: 1024px) {
    .menu-container {
        padding: 0.8rem;
    }
    
    .products {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.2rem;
    }
}

/* Mobil için medya sorguları */
@media (max-width: 768px) {
    .menu-container {
        padding: 0.5rem;
    }
    
    .menu-container h1 {
        margin-bottom: 1.2rem;
    }
    
    .categories {
        gap: 1.5rem;
    }
    
    .category h2 {
        font-size: 1.3rem;
    }
    
    .products {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .product-image {
        height: 180px;
    }
}

/* Küçük mobil cihazlar için */
@media (max-width: 480px) {
    .product-info {
        padding: 1rem;
    }
    
    .quantity-btn {
        width: 28px;
        height: 28px;
    }
    
    .quantity-input {
        width: 45px;
        padding: 0.4rem;
    }
    
    .order-btn {
        padding: 0.7rem;
    }
}

/* Bildirim Stilleri */
.notification {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 15px 25px;
    border-radius: 8px;
    color: white;
    font-weight: 500;
    z-index: 1000;
    animation: slide-in 0.3s ease-out;
    box-shadow: 0 3px 10px rgba(0,0,0,0.2);
}

.notification.success {
    background-color: #4CAF50;
}

.notification.error {
    background-color: #f44336;
}

.notification.fade-out {
    animation: fade-out 0.3s ease-out forwards;
}

@keyframes slide-in {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes fade-out {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(100%);
        opacity: 0;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Miktar kontrol butonları için event listener'lar
    document.querySelectorAll('.quantity-btn').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.parentElement.querySelector('.quantity-input');
            const currentValue = parseInt(input.value);
            
            if (this.classList.contains('plus')) {
                input.value = currentValue + 1;
            } else if (this.classList.contains('minus') && currentValue > 1) {
                input.value = currentValue - 1;
            }
        });
    });
    
    // Sipariş formları için AJAX gönderimi
    document.querySelectorAll('.order-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitButton = this.querySelector('.order-btn');
            const originalText = submitButton.textContent;
            
            // Butonu devre dışı bırak ve yükleniyor göster
            submitButton.disabled = true;
            submitButton.textContent = 'Sipariş Gönderiliyor...';
            
            fetch('/order', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Sunucu hatası');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    this.querySelector('.quantity-input').value = 1;
                } else {
                    showNotification(data.message || 'Bir hata oluştu', 'error');
                }
            })
            .catch(error => {
                console.error('Hata:', error);
                showNotification('Sipariş gönderilirken bir hata oluştu. Lütfen tekrar deneyin.', 'error');
            })
            .finally(() => {
                // Her durumda butonu normal haline getir
                submitButton.disabled = false;
                submitButton.textContent = originalText;
            });
        });
    });
    
    // Bildirim gösterme fonksiyonu
    function showNotification(message, type = 'success') {
        // Varsa eski bildirimi kaldır
        const existingNotification = document.querySelector('.notification');
        if (existingNotification) {
            existingNotification.remove();
        }
        
        // Yeni bildirimi oluştur
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.textContent = message;
        
        // Bildirimi sayfaya ekle
        document.body.appendChild(notification);
        
        // 3 saniye sonra bildirimi kaldır
        setTimeout(() => {
            notification.classList.add('fade-out');
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
    
    // Sayfa yüklendiğinde animasyon efekti
    const productCards = document.querySelectorAll('.product-card');
    productCards.forEach((card, index) => {
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>
