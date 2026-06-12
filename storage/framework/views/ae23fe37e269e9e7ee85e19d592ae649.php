<?php $__env->startSection('title', $branch['label'].' - Record'); ?>
<?php $__env->startSection('page_title', 'Record '.$branch['label']); ?>

<?php $__env->startSection('content'); ?>
<section class="section-card">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Riwayat Transaksi</p>
            <h2>Record <?php echo e($branch['label']); ?></h2>
            <p>Filter berdasarkan tanggal update untuk audit stok harian.</p>
        </div>
        <a class="ghost-link" href="<?php echo e($inventory->legacyBranchUrl($branch['slug'])); ?>">Kembali</a>
    </div>

    <form method="get" class="filter-form">
        <label>
            <span>Tanggal</span>
            <input class="date-input" type="date" name="tanggal" value="<?php echo e($tanggal); ?>">
        </label>
        <button class="launch-button small" type="submit">Filter</button>
        <a class="ghost-link" href="<?php echo e($inventory->legacyRecordUrl($branch['slug'])); ?>">Reset</a>
    </form>

    <div class="totals-row">
        <?php $__empty_1 = true; $__currentLoopData = $totals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $origin => $total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="metric-card compact">
                <span><?php echo e($origin); ?></span>
                <strong><?php echo e($total); ?></strong>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="metric-card compact">
                <span>Total</span>
                <strong>0</strong>
            </div>
        <?php endif; ?>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Asal</th>
                    <th>Stok</th>
                    <th>Konfirmasi</th>
                    <th>Dibuat</th>
                    <th>Diupdate</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($record->id); ?></td>
                        <td><span class="code-pill"><?php echo e($record->kode); ?></span></td>
                        <td><?php echo e($record->nama); ?></td>
                        <td><?php echo e($record->asal ?: 'Stok Awal'); ?></td>
                        <td><?php echo e($record->stok); ?></td>
                        <td><span class="status-pill <?php echo e(strtolower($record->konfirmasi) === 'sudah' ? 'ok' : 'pending'); ?>"><?php echo e($record->konfirmasi); ?></span></td>
                        <td><?php echo e($record->created_at); ?></td>
                        <td><?php echo e($record->updated_at); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8">Tidak ada record pada filter ini.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pwa-stok\resources\views/pages/record.blade.php ENDPATH**/ ?>