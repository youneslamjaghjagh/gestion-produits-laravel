<?php $__env->startSection('content'); ?>
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <h2>Détails du produit : <?php echo e($product->name); ?></h2>
        <a href="<?php echo e(route('products.index')); ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Retour au catalogue
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center mb-3 mb-md-0">
                    <?php if($product->image_path): ?>
                        <img src="<?php echo e(asset('storage/' . $product->image_path)); ?>" alt="<?php echo e($product->name); ?>" class="img-fluid rounded border shadow-sm" style="max-height: 400px; object-fit: cover;">
                    <?php else: ?>
                        <div class="bg-light rounded border d-flex align-items-center justify-content-center h-100" style="min-height: 250px;">
                            <span class="text-muted"><i class="bi bi-image fs-1"></i><br>Aucune image</span>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-8">
                    <h3 class="text-primary"><?php echo e(number_format($product->price, 2, ',', ' ')); ?> €</h3>

                    <div class="mt-4">
                        <p><strong>Catégorie :</strong> <span class="badge bg-secondary"><?php echo e($product->category->name ?? 'Non classé'); ?></span></p>

                        <p><strong>État du stock :</strong>
                            <?php if($product->stock == 0): ?>
                                <span class="badge bg-danger fs-6">Rupture de stock</span>
                            <?php else: ?>
                                <span class="badge bg-success fs-6"><?php echo e($product->stock); ?> unités en stock</span>
                            <?php endif; ?>
                        </p>

                        <p><strong>Ajouté le :</strong> <?php echo e($product->created_at->format('d/m/Y à H:i')); ?></p>
                        <p><strong>Dernière mise à jour :</strong> <?php echo e($product->updated_at->format('d/m/Y à H:i')); ?></p>
                    </div>

                    <div class="mt-4">
                        <h5>Description</h5>
                        <div class="p-3 bg-light rounded border">
                            <?php echo nl2br(e($product->description)) ?: '<em class="text-muted">Aucune description fournie.</em>'; ?>

                        </div>
                    </div>

                    <div class="mt-5 d-flex gap-2">
                        <a href="<?php echo e(route('products.edit', $product->id)); ?>" class="btn btn-primary">
                            <i class="bi bi-pencil"></i> Modifier ce produit
                        </a>

                        <form action="<?php echo e(route('products.destroy', $product->id)); ?>" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="bi bi-trash"></i> Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/products/show.blade.php ENDPATH**/ ?>