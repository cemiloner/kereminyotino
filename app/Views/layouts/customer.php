<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restoran - Müşteri Arayüzü</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            background-color: var(--bg-color);
            color: var(--text-color);
            overflow-x: hidden;
        }

        .navbar {
            background-color: var(--text-color);
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: var(--shadow);
        }

        .navbar-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0.8rem 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--white);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .navbar-brand i {
            color: var(--primary-color);
        }

        .navbar-menu {
            display: flex;
            gap: 1rem;
        }

        .navbar-menu a {
            color: var(--white);
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: var(--border-radius);
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .navbar-menu a:hover {
            background-color: var(--primary-color);
        }

        .navbar-menu a i {
            font-size: 1.1em;
        }

        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            color: var(--white);
            font-size: 1.5rem;
            cursor: pointer;
        }

        .main-content {
            min-height: calc(100vh - 60px);
            padding: 1rem;
        }

        /* Tablet için medya sorguları */
        @media (max-width: 1024px) {
            .navbar-container {
                padding: 0.8rem;
            }

            .navbar-menu a {
                padding: 0.5rem 0.8rem;
            }
        }

        /* Mobil için medya sorguları */
        @media (max-width: 768px) {
            .navbar-container {
                padding: 0.8rem;
            }

            .mobile-menu-btn {
                display: block;
            }

            .navbar-menu {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background-color: var(--text-color);
                flex-direction: column;
                padding: 1rem;
                gap: 0.5rem;
            }

            .navbar-menu.active {
                display: flex;
            }

            .navbar-menu a {
                padding: 0.8rem;
                width: 100%;
                justify-content: center;
            }
        }

        /* Küçük mobil cihazlar için */
        @media (max-width: 480px) {
            .navbar-brand {
                font-size: 1.2rem;
            }

            .main-content {
                padding: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <a href="/" class="navbar-brand">
                <i class="fas fa-utensils"></i>
                Restoran
            </a>
            <button class="mobile-menu-btn">
                <i class="fas fa-bars"></i>
            </button>
            <div class="navbar-menu">
                <a href="/"><i class="fas fa-home"></i> Anasayfa</a>
                <a href="/menu"><i class="fas fa-utensils"></i> Menü</a>
                <a href="/order"><i class="fas fa-shopping-cart"></i> Sipariş Ver</a>
            </div>
        </div>
    </nav>

    <div class="main-content">
        <?= $content ?? '' ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
            const navbarMenu = document.querySelector('.navbar-menu');
            
            mobileMenuBtn.addEventListener('click', function() {
                navbarMenu.classList.toggle('active');
            });

            // Sayfa yüklendiğinde veya yeniden boyutlandırıldığında menüyü kontrol et
            function checkMenu() {
                if (window.innerWidth > 768) {
                    navbarMenu.classList.remove('active');
                }
            }

            window.addEventListener('resize', checkMenu);
            checkMenu();
        });
    </script>
</body>
</html> 