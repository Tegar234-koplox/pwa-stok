<?php $__env->startSection('title', $branch['label'].' - Terima dari '.$source['short']); ?>
<?php $__env->startSection('page_title', 'Terima dari '.$source['short']); ?>

<?php $__env->startSection('content'); ?>
<section class="section-card">
    <div class="section-heading">
        <div>
            <p class="eyebrow"><?php echo e($source['short']); ?> → <?php echo e($branch['short']); ?></p>
            <h2>Konfirmasi Stok Masuk</h2>
            <p>Konfirmasi akan mengubah status seluruh stok masuk dengan nama barang yang sama menjadi <strong>Sudah</strong>.</p>
        </div>
        <a class="ghost-link" href="<?php echo e($inventory->legacyBranchUrl($branch['slug'])); ?>">Kembali</a>
    </div>

    <div class="receive-grid">
        <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <article class="receive-card <?php echo e($item->is_excluded ? 'muted' : ''); ?>">
                <div>
                    <span class="code-pill"><?php echo e($item->kode); ?></span>
                    <h3><?php echo e($item->nama); ?></h3>
                    <p>Menunggu konfirmasi dari <?php echo e($source['short']); ?></p>
                </div>
                <div class="receive-amount"><?php echo e($item->jumlah); ?></div>
                <form method="post">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="nama" value="<?php echo e($item->nama); ?>">
                    <button class="launch-button small" type="submit">Konfirmasi</button>
                </form>
            </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <article class="empty-state">
                Tidak ada stok masuk dari <?php echo e($source['short']); ?> yang belum dikonfirmasi.
            </article>
        <?php endif; ?>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pwa-stok\resources\views/pages/receive.blade.php ENDPATH**/ ?>