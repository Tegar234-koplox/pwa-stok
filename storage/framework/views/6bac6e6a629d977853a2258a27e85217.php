<?php $__env->startSection('title', $branch['label'] . ' - Dashboard'); ?>
<?php $__env->startSection('page_title', $branch['title']); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $lowCount = $cards->where('is_low', true)->count();
        $incomingTotal = $cards->sum('masuk');
    ?>

    <section class="summary-grid">
        <article class="metric-card">
            <span>Total Produk</span>
            <strong><?php echo e($cards->count()); ?></strong>
        </article>
        <article class="metric-card">
            <span>Stok Menipis</span>
            <strong><?php echo e($lowCount); ?></strong>
        </article>
        <article class="metric-card">
            <span>Belum Dikonfirmasi</span>
            <strong><?php echo e($incomingTotal); ?></strong>
        </article>
    </section>

    <section class="inventory-grid">
        <?php $__empty_1 = true; $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <article class="stock-card <?php echo e($card->is_low ? 'is-warning' : ''); ?>">
                <div class="stock-badges">
                    <?php if($card->show_incoming): ?>
                        <span class="badge badge-incoming">+<?php echo e($card->masuk); ?></span>
                    <?php endif; ?>
                    <?php if($card->is_low): ?>
                        <span class="badge badge-danger">!</span>
                    <?php endif; ?>
                </div>

                <div class="stock-code"><?php echo e($card->kode); ?></div>
                <h2><?php echo e($card->nama); ?></h2>
                <p class="stock-label">Stok tersedia</p>
                <div class="stock-value"><?php echo e($card->stok); ?></div>

                <?php if($branch['quick_adjust']): ?>
                    <form method="post" class="quick-form" data-stock-form>
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="nama" value="<?php echo e($card->nama); ?>">
                        <input type="hidden" name="aksi_stok" value="" data-action-field>
                        <div class="segmented-actions">
                            <button type="button" class="segment-btn" data-action="tambah">＋</button>
                            <button type="button" class="segment-btn" data-action="kurang">－</button>
                        </div>
                        <input class="number-input" type="number" name="jumlah" min="1" placeholder="Jumlah"
                            required>
                        <button class="save-btn" type="submit" disabled data-save-button>Simpan</button>
                    </form>
                <?php endif; ?>
            </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <article class="empty-state">Data stok kosong.</article>
        <?php endif; ?>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pwa-stok\resources\views/pages/dashboard.blade.php ENDPATH**/ ?>