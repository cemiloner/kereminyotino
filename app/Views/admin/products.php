<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ürün Listesi</title>
</head>
<body>
<h1>Ürün Listesi</h1>
<ul>
    <?php if(!empty($products)): ?>
        <?php foreach($products as $p): ?>
            <li><?= $p->name ?> (Stok: <?= $p->stock ?>)</li>
        <?php endforeach; ?>
    <?php else: ?>
        <li>Hiç ürün yok.</li>
    <?php endif; ?>
</ul>
</body>
</html>
