<?php $__env->startSection('title', $branch['label'].' - '.$title); ?>
<?php $__env->startSection('page_title', $title); ?>

<?php $__env->startSection('content'); ?>
<section class="section-card">
    <div class="section-heading">
        <div>
            <p class="eyebrow"><?php echo e($branch['label']); ?></p>
            <h2><?php echo e($title); ?></h2>
            <p><?php echo e($subtitle); ?></p>
        </div>
        <a class="ghost-link" href="<?php echo e($inventory->legacyBranchUrl($branch['slug'])); ?>">Kembali</a>
    </div>

    <div class="table-wrap action-list">
        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><span class="code-pill"><?php echo e($item->kode); ?></span></td>
                        <td><?php echo e($item->nama); ?></td>
                        <td><?php echo e($item->stok); ?></td>
                        <td>
                            <form method="post" class="row-form">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="id" value="<?php echo e($item->id); ?>">
                                <input class="number-input" type="number" name="jumlah_kirim" min="1" max="100000" placeholder="Jumlah" required>
                                <button class="launch-button small" type="submit"><?php echo e($submitLabel); ?></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4">Data barang kosong.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pwa-stok\resources\views/pages/action.blade.php ENDPATH**/ ?>