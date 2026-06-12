<?php $__env->startSection('title', 'Stock Management System'); ?>

<?php $__env->startSection('content'); ?>
    <main class="home-shell">
        <section class="home-hero cosmic-card">
            <div class="hero-copy">
                <p class="eyebrow">Stock Management System</p>
                <h1>Akang Seafood</h1>
            </div>
            <div class="hero-orb" aria-hidden="true"></div>
        </section>

        <section class="branch-grid" aria-label="Pilih cabang">
            <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slug => $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <article class="launch-card">
                    <div class="particle-field" aria-hidden="true"></div>
                    <div class="launch-card-content">
                        <p class="eyebrow">Cabang</p>
                        <h2><?php echo e($branch['label']); ?></h2>
                        <p><?php echo e($branch['description']); ?></p>
                    </div>
                    <a class="launch-button" href="<?php echo e($inventory->legacyBranchUrl($slug)); ?>">Launch</a>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </section>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pwa-stok\resources\views/pages/home.blade.php ENDPATH**/ ?>