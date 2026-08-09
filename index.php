<?php
// index.php
require_once __DIR__ . '/templates/header.php';

// Fetch Data
$featured_apps = get_featured_apps($pdo);
$services = get_all_services($pdo);
?>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <h1>Discover Premium Apps <br> <span class="text-gradient">For Your Lifestyle</span></h1>
        <p>Explore our curated collection of top-tier mobile and web applications, or hire our expert team to build your dream app from scratch.</p>
        <div class="hero-btns">
            <a href="<?= BASE_URL ?>modules/apps/index.php" class="btn btn-primary">Explore Apps</a>
            <a href="<?= BASE_URL ?>services.php" class="btn btn-outline">Our Services</a>
        </div>
    </div>
</section>

<!-- Featured Apps Section -->
<section class="section bg-alt" id="featured-apps">
    <div class="container">
        <h2 class="section-title">Featured <span class="text-gradient">Apps</span></h2>
        
        <div class="grid">
            <?php if (count($featured_apps) > 0): ?>
                <?php foreach ($featured_apps as $app): ?>
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
                                    <span style="color: var(--text-secondary); margin-left: 5px;">(<?= number_format($app['downloads']) ?>+ DLs)</span>
                                </div>
                            </div>
                        </div>
                        
                        <p class="app-desc" title="<?= htmlspecialchars($app['description']) ?>">
                            <?= htmlspecialchars(get_excerpt($app['description'], 120)) ?>
                        </p>
                        
                        <div style="display: flex; gap: 10px;">
                            <a href="<?= BASE_URL ?>modules/apps/details.php/<?= $app['slug'] ?>" class="btn btn-outline" style="flex: 1; text-align: center; padding: 10px;">View Details</a>
                            <a href="<?= htmlspecialchars($app['apk_download_link'] ?? '#') ?>" class="btn btn-primary btn-icon" title="Download APK" target="_blank"><i class='bx bxs-download'></i></a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align: center; grid-column: 1 / -1; color: var(--text-secondary);">No featured apps found.</p>
            <?php endif; ?>
        </div>
        
        <div style="text-align: center; margin-top: 50px;">
            <a href="<?= BASE_URL ?>modules/apps/index.php" class="btn btn-outline">View All Apps</a>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="section" id="services">
    <div class="container">
        <h2 class="section-title">Our <span class="text-gradient">Expertise</span></h2>
        
        <div class="grid">
            <?php if (count($services) > 0): ?>
                <?php foreach ($services as $service): ?>
                    <div class="service-card">
                        <i class='bx <?= htmlspecialchars($service['icon']) ?> service-icon'></i>
                        <h3><?= htmlspecialchars($service['name']) ?></h3>
                        <p><?= htmlspecialchars($service['description']) ?></p>
                        <a href="<?= BASE_URL ?>services.php" style="color: var(--accent-primary); font-weight: 500; display: inline-block; margin-top: 20px;">Learn More <i class='bx bx-right-arrow-alt'></i></a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align: center; grid-column: 1 / -1; color: var(--text-secondary);">No services found.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="section bg-alt" style="position: relative; overflow: hidden;">
    <div style="position: absolute; right: -10%; top: -20%; width: 500px; height: 500px; background: var(--accent-gradient); filter: blur(100px); opacity: 0.2; border-radius: 50%;"></div>
    <div class="container" style="text-align: center; position: relative; z-index: 2;">
        <h2 class="section-title" style="margin-bottom: 20px;">Ready to Start Your Project?</h2>
        <p style="color: var(--text-secondary); max-width: 600px; margin: 0 auto 40px; font-size: 1.2rem;">
            Whether you need a cutting-edge mobile app or a scalable web platform, our team of experts is ready to bring your vision to life.
        </p>
        <a href="<?= BASE_URL ?>contact.php" class="btn btn-primary" style="font-size: 1.1rem; padding: 15px 40px;">Request a Quote</a>
    </div>
</section>

<?php require_once __DIR__ . '/templates/footer.php'; ?>
