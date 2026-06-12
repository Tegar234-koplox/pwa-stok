<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0f172a">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Akang Seafood'); ?></title>
    <link rel="icon" type="image/png" href="<?php echo e(asset('images/akangseafood.png')); ?>">
    <link rel="icon" href="<?php echo e(asset('akangseafood.png')); ?>" type="image/png">
    <link rel="manifest" href="<?php echo e(asset('manifest.webmanifest')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
</head>

<body>
    <div class="page-glow" aria-hidden="true"></div>

    <?php if(isset($branch)): ?>
        <div class="app-shell">
            <?php echo $__env->make('components.sidebar', [
                'branch' => $branch,
                'peers' => $peers ?? [],
                'badges' => $badges ?? [],
                'inventory' => $inventory,
            ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <main class="workspace" id="workspace">
                <header class="topbar">
                    <button class="icon-button" type="button" data-sidebar-toggle aria-label="Buka menu">
                        <span></span><span></span><span></span>
                    </button>
                    <div>
                        <p class="eyebrow">Akang Seafood</p>
                        <h1><?php echo $__env->yieldContent('page_title', $branch['title']); ?></h1>
                        <p class="topbar-date" id="tanggalHari"></p>
                    </div>
                    <a class="ghost-link" href="<?php echo e(url('index.php')); ?>">Menu Utama</a>
                </header>

                <?php echo $__env->make('components.flash', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>
    <?php else: ?>
        <?php echo $__env->make('components.flash', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->yieldContent('content'); ?>
    <?php endif; ?>

    <script src="<?php echo e(asset('js/app.js')); ?>" defer></script>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\pwa-stok\resources\views/layouts/app.blade.php ENDPATH**/ ?>