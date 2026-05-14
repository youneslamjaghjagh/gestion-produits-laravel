<?php $__env->startSection('content'); ?>
    <div class="mb-4">
        <h2>Modifier le produit : <?php echo e($product->name); ?></h2>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="<?php echo e(route('products.update', $product->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nom du produit</label>
                        <input type="text" class="form-control" name="name" value="<?php echo e(old('name', $product->name)); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Catégorie</label>
                        <select class="form-select" name="category_id" required>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>" <?php echo e((old('category_id', $product->category_id) == $category->id) ? 'selected' : ''); ?>>
                                    <?php echo e($category->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" name="description" rows="3"><?php echo e(old('description', $product->description)); ?></textarea>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Prix (€)</label>
                        <input type="number" step="0.01" class="form-control" name="price" value="<?php echo e(old('price', $product->price)); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Stock</label>
                        <input type="number" class="form-control" name="stock" value="<?php echo e(old('stock', $product->stock)); ?>" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Mettre à jour</button>
                <a href="<?php echo e(route('products.index')); ?>" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/products/edit.blade.php ENDPATH**/ ?>