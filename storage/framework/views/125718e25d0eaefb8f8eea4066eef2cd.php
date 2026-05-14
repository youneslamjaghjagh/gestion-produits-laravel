<!DOCTYPE html>
<html>
<head>
    <title>Rapport d'Inventaire</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { bg-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 30px; }
    </style>
</head>
<body>
<div class="header">
    <h1>Rapport d'Inventaire des Produits</h1>
    <p>Généré le : <?php echo e(date('d/m/Y H:i')); ?></p>
</div>

<div>
    <strong>Total Produits :</strong> <?php echo e($stats['total_products']); ?> |
    <strong>Valeur du Stock :</strong> <?php echo e(number_format($stats['total_value'], 2)); ?> €
</div>

<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Catégorie</th>
        <th>Prix</th>
        <th>Stock</th>
    </tr>
    </thead>
    <tbody>
    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($product->id); ?></td>
            <td><?php echo e($product->name); ?></td>
            <td><?php echo e($product->category->name ?? 'N/A'); ?></td>
            <td><?php echo e(number_format($product->price, 2)); ?> €</td>
            <td><?php echo e($product->stock); ?></td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
</body>
</html>
<?php /**PATH /var/www/html/resources/views/products/pdf.blade.php ENDPATH**/ ?>