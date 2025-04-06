<?php include __DIR__ . '/layouts/customer.php'; ?>

<div class="home-container">
    <div class="welcome-section">
        <h1>Hoş Geldiniz</h1>
        <p>Lezzetli yemeklerimizi keşfedin ve siparişinizi hemen verin.</p>
        <a href="/menu" class="cta-button">Sipariş Ver</a>
    </div>

    <div class="features">
        <div class="feature-card">
            <i class="fas fa-utensils"></i>
            <h3>Taze Malzemeler</h3>
            <p>En taze ve kaliteli malzemelerle hazırlanan lezzetli yemekler.</p>
        </div>
        <div class="feature-card">
            <i class="fas fa-clock"></i>
            <h3>Hızlı Servis</h3>
            <p>Siparişleriniz en kısa sürede hazırlanıp kapınıza teslim edilir.</p>
        </div>
        <div class="feature-card">
            <i class="fas fa-smile"></i>
            <h3>Müşteri Memnuniyeti</h3>
            <p>Müşteri memnuniyeti bizim için her şeyden önemlidir.</p>
        </div>
    </div>

    <div class="feedback-section">
        <h2>Geri Bildirim</h2>
        <p>Görüş ve önerilerinizi bizimle paylaşın.</p>
        <form action="/feedback" method="post" class="feedback-form">
            <div class="form-group">
                <label for="name">Adınız</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">E-posta</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="message">Mesajınız</label>
                <textarea id="message" name="message" rows="4" required></textarea>
            </div>
            <button type="submit" class="submit-button">Gönder</button>
        </form>
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

.home-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 1rem;
}

.welcome-section {
    text-align: center;
    padding: 3rem 1.5rem;
    background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('/public/images/restaurant-bg.jpg');
    background-size: cover;
    background-position: center;
    color: var(--white);
    border-radius: var(--border-radius);
    margin-bottom: 2rem;
    box-shadow: var(--shadow);
}

.welcome-section h1 {
    font-size: clamp(2rem, 5vw, 2.5rem);
    margin-bottom: 1rem;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.welcome-section p {
    font-size: clamp(1rem, 3vw, 1.1rem);
    margin-bottom: 1.5rem;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.cta-button {
    display: inline-block;
    padding: 0.8rem 1.5rem;
    background-color: var(--primary-color);
    color: var(--white);
    text-decoration: none;
    border-radius: var(--border-radius);
    font-size: 1.1rem;
    transition: var(--transition);
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}

.cta-button:hover {
    background-color: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.features {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.feature-card {
    text-align: center;
    padding: 1.5rem;
    background: var(--white);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    transition: var(--transition);
}

.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.feature-card i {
    font-size: 2.5rem;
    color: var(--primary-color);
    margin-bottom: 1rem;
}

.feature-card h3 {
    margin-bottom: 0.8rem;
    color: var(--text-color);
    font-size: 1.2rem;
}

.feature-card p {
    color: var(--text-light);
    font-size: 0.95rem;
    line-height: 1.5;
}

.feedback-section {
    background: var(--white);
    padding: 2rem;
    border-radius: var(--border-radius);
    text-align: center;
    box-shadow: var(--shadow);
}

.feedback-section h2 {
    margin-bottom: 1rem;
    color: var(--text-color);
    font-size: 1.5rem;
}

.feedback-section p {
    margin-bottom: 1.5rem;
    color: var(--text-light);
}

.feedback-form {
    max-width: 600px;
    margin: 0 auto;
    text-align: left;
}

.form-group {
    margin-bottom: 1rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    color: var(--text-color);
    font-weight: 500;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 0.8rem;
    border: 1px solid #ddd;
    border-radius: var(--border-radius);
    font-size: 1rem;
    transition: var(--transition);
}

.form-group input:focus,
.form-group textarea:focus {
    border-color: var(--primary-color);
    outline: none;
    box-shadow: 0 0 0 2px rgba(76, 175, 80, 0.2);
}

.submit-button {
    background-color: var(--primary-color);
    color: var(--white);
    border: none;
    padding: 0.8rem 1.5rem;
    border-radius: var(--border-radius);
    cursor: pointer;
    font-size: 1rem;
    transition: var(--transition);
    width: 100%;
    margin-top: 0.5rem;
}

.submit-button:hover {
    background-color: var(--primary-dark);
    transform: translateY(-2px);
}

/* Tablet için medya sorguları */
@media (max-width: 1024px) {
    .home-container {
        padding: 0.8rem;
    }
    
    .welcome-section {
        padding: 2.5rem 1.2rem;
    }
    
    .features {
        gap: 1.2rem;
    }
}

/* Mobil için medya sorguları */
@media (max-width: 768px) {
    .home-container {
        padding: 0.5rem;
    }
    
    .welcome-section {
        padding: 2rem 1rem;
        margin-bottom: 1.5rem;
    }
    
    .features {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .feedback-section {
        padding: 1.5rem;
    }
}

/* Küçük mobil cihazlar için */
@media (max-width: 480px) {
    .welcome-section {
        padding: 1.5rem 1rem;
    }
    
    .feature-card {
        padding: 1.2rem;
    }
    
    .feedback-section {
        padding: 1.2rem;
    }
    
    .form-group input,
    .form-group textarea {
        padding: 0.7rem;
    }
}
</style> 