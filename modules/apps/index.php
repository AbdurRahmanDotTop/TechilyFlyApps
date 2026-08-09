<?php
// modules/apps/index.php
require_once __DIR__ . '/../../templates/header.php';

// Fetch data
$categories = get_active_categories($pdo);
$filters = [
    'search' => $_GET['search'] ?? '',
    'category' => $_GET['category'] ?? '',
    'sort' => $_GET['sort'] ?? 'latest'
];
$apps = get_filtered_apps($pdo, $filters);
?>

<section class="hero" style="padding: 120px 0 60px;">
    <div class="container">
        <h1>App <span class="text-gradient">Store</span></h1>
        <p>Browse our complete collection of high-quality mobile and web applications.</p>
    </div>
</section>

<section class="section pt-0">
    <div class="container">
        
        <!-- App Filters / Search Bar -->
        <form method="GET" action="<?= BASE_URL ?>modules/apps/index.php" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; flex-wrap: wrap; gap: 20px;">
            <div style="flex: 1; min-width: 250px; max-width: 400px; position: relative;">
                <i class='bx bx-search' style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-secondary); font-size: 1.2rem;"></i>
                <input type="text" name="search" value="<?= htmlspecialchars($filters['search']) ?>" placeholder="Search apps..." style="width: 100%; padding: 12px 15px 12px 45px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-secondary); color: var(--text-primary); outline: none;" onchange="this.form.submit()">
            </div>
            
            <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                <select name="category" onchange="this.form.submit()" style="padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-secondary); color: var(--text-primary); outline: none; min-width: 150px;">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= htmlspecialchars($cat['slug']) ?>" <?= $filters['category'] == $cat['slug'] ? 'selected' : '' ?>><?= htmlspecialchars($cat['name']) ?></option>
                    <?php endforeach; ?>
                </select>
                <select name="sort" onchange="this.form.submit()" style="padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-secondary); color: var(--text-primary); outline: none; min-width: 150px;">
                    <option value="latest" <?= $filters['sort'] == 'latest' ? 'selected' : '' ?>>Latest</option>
                    <option value="popular" <?= $filters['sort'] == 'popular' ? 'selected' : '' ?>>Most Popular</option>
                    <option value="rating" <?= $filters['sort'] == 'rating' ? 'selected' : '' ?>>Top Rated</option>
                </select>
            </div>
        </form>

        <!-- Apps Grid -->
        <div class="grid">
            <?php if (count($apps) > 0): ?>
                <?php foreach ($apps as $app): ?>
                    <div class="app-card">
                        <?php if ($app['is_featured']): ?>
                            <div style="position: absolute; top: 10px; right: 10px;" class="badge">Featured</div>
                        <?php endif; ?>
                        
                        <div class="app-header">
                            <img src="<?= htmlspecialchars($app['logo_url']) ?>" alt="<?= htmlspecialchars($app['name']) ?> Logo" class="app-logo">
                            <div class="app-info">
                                <h3><?= htmlspecialchars($app['name']) ?></h3>
                                <span class="app-category"><?= htmlspecialchars($app['category_name']) ?></span>
                                <div class="app-rating">
                                    <i class='bx bxs-star'></i> <?= number_format($app['rating'], 1) ?>
                                </div>
                            </div>
                        </div>
                        
                        <p class="app-desc">
                            <?= htmlspecialchars($app['description']) ?>
                        </p>
                        
                        <div style="display: flex; gap: 10px;">
                            <a href="<?= BASE_URL ?>modules/apps/details.php/<?= $app['slug'] ?>" class="btn btn-outline" style="flex: 1; text-align: center; padding: 10px;">Details</a>
                            <a href="<?= htmlspecialchars($app['apk_download_link'] ?? '#') ?>" class="btn btn-primary" style="padding: 10px 15px;" target="_blank"><i class='bx bxs-download'></i></a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align: center; grid-column: 1 / -1; color: var(--text-secondary);">No apps found.</p>
            <?php endif; ?>
        </div>
        
    </div>
</section>

<?php require_once __DIR__ . '/../../templates/footer.php'; ?>
