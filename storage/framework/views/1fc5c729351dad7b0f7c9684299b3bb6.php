<?php
    $currentPath = trim(request()->path(), '/');

    $branchSlug = $branch['slug'] ?? '';
    $branchLabel = $branch['label'] ?? ($branch['short'] ?? ucfirst($branchSlug));

    $peers = collect($peers ?? [])
        ->filter(fn($peer) => is_array($peer))
        ->map(function (array $peer) {
            if (empty($peer['slug'])) {
                $peer['slug'] = \Illuminate\Support\Str::slug(
                    $peer['short'] ?? ($peer['label'] ?? ($peer['title'] ?? '')),
                );
            }

            return $peer;
        })
        ->filter(fn(array $peer) => !empty($peer['slug']))
        ->values();
?>
<aside class="sidebar" id="sidebar">
    <div class="brand-block">
        <img src="<?php echo e(asset('images/akangseafood.png')); ?>" alt="Logo" class="brand-logo">
        <div>
            <p>Inventory</p>
            <strong><?php echo e($branch['label']); ?></strong>
        </div>
    </div>

    <nav class="nav-list" aria-label="Navigasi cabang">
        <a class="nav-item <?php echo e($currentPath === $branchSlug . '.php' ? 'active' : ''); ?>"
            href="<?php echo e($inventory->legacyBranchUrl($branchSlug)); ?>">
            <span>Dashboard</span>
        </a>

        <div class="nav-section">Penerimaan</div>
        <?php $__currentLoopData = $peers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $peer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $peerSlug = $peer['slug'];
                $path = $branchSlug . '-terima-dari-' . $peerSlug . '.php';
            ?>

            <a class="nav-item <?php echo e($currentPath === $path ? 'active' : ''); ?>"
                href="<?php echo e($inventory->legacyReceiveUrl($branchSlug, $peerSlug)); ?>">
                <span>Terima dari <?php echo e($peer['short'] ?? ($peer['label'] ?? ucfirst($peerSlug))); ?></span>

                <?php if(($badges[$peerSlug] ?? 0) > 0): ?>
                    <span class="nav-badge"><?php echo e($badges[$peerSlug]); ?></span>
                <?php endif; ?>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <div class="nav-section">Distribusi</div>
        <?php $__currentLoopData = $peers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $peer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $peerSlug = $peer['slug'];
                $path = $branchSlug . '-kirim-ke-' . $peerSlug . '.php';
            ?>

            <a class="nav-item <?php echo e($currentPath === $path ? 'active' : ''); ?>"
                href="<?php echo e($inventory->legacyTransferUrl($branchSlug, $peerSlug)); ?>">
                <span>Kirim ke <?php echo e($peer['short'] ?? ($peer['label'] ?? ucfirst($peerSlug))); ?></span>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <div class="nav-section">Operasional</div>
        <a class="nav-item <?php echo e($currentPath === $branch['slug'] . '-penjualan.php' ? 'active' : ''); ?>"
            href="<?php echo e($inventory->legacyMovementUrl($branch['slug'], 'penjualan')); ?>">
            <span>Penjualan</span>
        </a>
        <a class="nav-item <?php echo e($currentPath === $branch['slug'] . '-rusak.php' ? 'active' : ''); ?>"
            href="<?php echo e($inventory->legacyMovementUrl($branch['slug'], 'rusak')); ?>">
            <span>Rusak/Hilang</span>
        </a>
        <a class="nav-item <?php echo e($currentPath === $branch['slug'] . '-record.php' ? 'active' : ''); ?>"
            href="<?php echo e($inventory->legacyRecordUrl($branch['slug'])); ?>">
            <span>Record</span>
        </a>
        <a class="nav-item" href="<?php echo e(url('index.php')); ?>">
            <span>Menu Utama</span>
        </a>
    </nav>
</aside>
<div class="sidebar-backdrop" data-sidebar-toggle></div>
<?php /**PATH C:\xampp\htdocs\pwa-stok\resources\views/components/sidebar.blade.php ENDPATH**/ ?>