<?php
// Veritabanı bağlantısı (db.php dosyasını dahil ettiğinizden emin olun)
include 'db.php';

// Ürünleri veritabanından çekme
$stmt = $pdo->query('SELECT * FROM products');
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pastane Ürünleri</title>
</head>
<body>
    <h1>Pastane Ürünleri</h1>
    
    <table border="1">
        <thead>
            <tr>
                <th>Ürün Adı</th>
                <th>Açıklama</th>
                <th>Fiyat</th>
                <th>Stok Miktarı</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Her bir ürünü döngü ile al ve tabloya yazdır
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                echo "<td>" . htmlspecialchars($row['price']) . " TL</td>";
                echo "<td>" . htmlspecialchars($row['stock_quantity']) . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
