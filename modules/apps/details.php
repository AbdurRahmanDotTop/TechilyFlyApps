<?php
// modules/apps/details.php
require_once __DIR__ . '/../../templates/header.php';

// First try to get slug from PATH_INFO, fallback to GET parameter
$slug = '';
if (isset($_SERVER['PATH_INFO']) && !empty(trim($_SERVER['PATH_INFO'], '/'))) {
    $slug = trim($_SERVER['PATH_INFO'], '/');
} else {
    $slug = $_GET['slug'] ?? '';
}

if (empty($slug)) {
    header('Location: ' . BASE_URL . 'modules/apps/index.php');
    exit;
}

$app = get_app_by_slug($pdo, $slug);

if (!$app) {
    echo "<section class='section'><div class='container'><h2>App not found.</h2><a href='" . BASE_URL . "modules/apps/index.php' class='btn btn-outline'>Back to Apps</a></div></section>";
    require_once __DIR__ . '/../../templates/footer.php';
    exit;
}
?>

<section class="app-detail-hero">
    <div class="container">
        <div class="app-detail-header">
            <img src="<?= htmlspecialchars($app['logo_url']) ?>" alt="<?= htmlspecialchars($app['name']) ?> Logo" class="app-detail-logo">
            <div class="app-detail-info">
                <h1><?= htmlspecialchars($app['name']) ?></h1>
                
                <div class="app-detail-meta">
                    <span><i class='bx bx-category' ></i> <?= htmlspecialchars($app['category_name']) ?></span>
                    <span><i class='bx bx-user' ></i> <?= htmlspecialchars($app['developer']) ?></span>
                    <span><i class='bx bx-purchase-tag' ></i> v<?= htmlspecialchars($app['version']) ?></span>
                    <span style="color: var(--warning);"><i class='bx bxs-star'></i> <?= number_format($app['rating'], 1) ?></span>
                    <span><i class='bx bx-download' ></i> <?= number_format($app['downloads']) ?>+</span>
                </div>
                
                <div class="app-detail-actions">
                    <?php if ($app['is_apk_active'] ?? 1): ?>
                    <a href="<?= empty($app['apk_download_link']) ? '#' : BASE_URL . 'modules/apps/download.php?id=' . $app['id'] . '&type=apk' ?>" <?= empty($app['apk_download_link']) ? 'onclick="alert(\'APK not available yet\'); return false;"' : 'target="_blank"' ?> class="btn btn-primary" style="padding: 15px 30px; font-size: 1.1rem;"><i class='bx bxs-download' style="margin-right: 5px;"></i> Download APK</a>
                    <?php endif; ?>
                    
                    <?php if ($app['is_play_store_active'] ?? 1): ?>
                    <a href="<?= empty($app['play_store_link']) ? '#' : BASE_URL . 'modules/apps/download.php?id=' . $app['id'] . '&type=playstore' ?>" <?= empty($app['play_store_link']) ? 'onclick="alert(\'Not available on Play Store yet\'); return false;"' : 'target="_blank"' ?> class="btn btn-outline" style="padding: 15px 30px; font-size: 1.1rem;"><i class='bx bxl-play-store' style="margin-right: 5px;"></i> Play Store</a>
                    <?php endif; ?>
                    
                    <?php if ($app['is_app_store_active'] ?? 1): ?>
                    <a href="<?= empty($app['app_store_link']) ? '#' : BASE_URL . 'modules/apps/download.php?id=' . $app['id'] . '&type=appstore' ?>" <?= empty($app['app_store_link']) ? 'onclick="alert(\'Not available on App Store yet\'); return false;"' : 'target="_blank"' ?> class="btn btn-outline" style="padding: 15px 30px; font-size: 1.1rem;"><i class='bx bxl-apple' style="margin-right: 5px;"></i> App Store</a>
                    <?php endif; ?>
                    
                    <?php if ($app['is_indus_store_active'] ?? 1): ?>
                    <a href="<?= empty($app['indus_store_link']) ? '#' : BASE_URL . 'modules/apps/download.php?id=' . $app['id'] . '&type=indus' ?>" <?= empty($app['indus_store_link']) ? 'onclick="alert(\'Not available on Indus Appstore yet\'); return false;"' : 'target="_blank"' ?> class="btn btn-outline" style="padding: 15px 30px; font-size: 1.1rem;"><i class='bx bxs-store' style="margin-right: 5px;"></i> Indus Appstore</a>
                    <?php endif; ?>
                    
                    <?php if ($app['is_amazon_store_active'] ?? 1): ?>
                    <a href="<?= empty($app['amazon_store_link']) ? '#' : BASE_URL . 'modules/apps/download.php?id=' . $app['id'] . '&type=amazon' ?>" <?= empty($app['amazon_store_link']) ? 'onclick="alert(\'Not available on Amazon Appstore yet\'); return false;"' : 'target="_blank"' ?> class="btn btn-outline" style="padding: 15px 30px; font-size: 1.1rem;"><i class='bx bxl-amazon' style="margin-right: 5px;"></i> Amazon Appstore</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section pt-0">
    <div class="container">
        <div class="details-grid">
            
            <!-- Main Content -->
            <div>
                <?php if (!empty($app['banner_url'])): ?>
                    <img src="<?= htmlspecialchars($app['banner_url']) ?>" alt="Banner" style="width: 100%; border-radius: var(--border-radius); margin-bottom: 40px;">
                <?php endif; ?>
                
                <h3 style="font-size: 1.8rem; margin-bottom: 20px;">About this app</h3>
                <div style="color: var(--text-secondary); line-height: 1.8;">
                    <?= nl2br(htmlspecialchars($app['description'])) ?>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div>
                <div class="app-card" style="padding: 30px;">
                    <h4 style="margin-bottom: 20px; font-size: 1.2rem; border-bottom: 1px solid var(--glass-border); padding-bottom: 10px;">Requirements</h4>
                    <p style="color: var(--text-secondary);">
                        <?= nl2br(htmlspecialchars($app['requirements'] ?? 'No specific requirements listed.')) ?>
                    </p>
                    
                    <h4 style="margin-top: 30px; margin-bottom: 20px; font-size: 1.2rem; border-bottom: 1px solid var(--glass-border); padding-bottom: 10px;">Information</h4>
                    <ul style="color: var(--text-secondary); line-height: 2;">
                        <li><strong>Developer:</strong> <?= htmlspecialchars($app['developer']) ?></li>
                        <li><strong>Category:</strong> <?= htmlspecialchars($app['category_name']) ?></li>
                        <li><strong>Published On:</strong> <?= !empty($app['publish_date']) ? date('M d, Y', strtotime($app['publish_date'])) : 'N/A' ?></li>
                        <li><strong>App Updated On:</strong> <?= !empty($app['app_update_date']) ? date('M d, Y', strtotime($app['app_update_date'])) : 'N/A' ?></li>
                        <li><strong>Page Last Modified:</strong> <?= !empty($app['updated_at']) ? date('M d, Y g:i A', strtotime($app['updated_at'])) : date('M d, Y g:i A', strtotime($app['created_at'])) ?></li>
                    </ul>
                </div>
            </div>
            
        </div>
    </div>
</section>

<section class="section pt-0">
    <div class="container">
        <div class="reviews-section">
            <h3 style="font-size: 1.8rem; margin-bottom: 20px;">User Reviews & Ratings</h3>
            
            <div id="reviews-container" class="reviews-carousel">
                <div class="loading-reviews" style="padding: 20px; color: var(--text-secondary);">
                    <i class='bx bx-loader-alt bx-spin'></i> Loading reviews...
                </div>
            </div>
            
            <div class="review-actions" style="margin-top: 20px; display: flex; gap: 15px; flex-wrap: wrap;">
                <?php if (!empty($app['play_store_link'])): ?>
                    <a href="<?= htmlspecialchars($app['play_store_link']) ?>" target="_blank" class="btn btn-outline"><i class='bx bxl-play-store'></i> Read More on Google Play <span id="play_count_badge" style="font-weight: bold; margin-left: 5px;"></span></a>
                <?php endif; ?>
                <?php if (!empty($app['indus_store_link'])): ?>
                    <a href="<?= htmlspecialchars($app['indus_store_link']) ?>" target="_blank" class="btn btn-outline"><i class='bx bxs-store'></i> Read More on Indus App Store <span id="indus_count_badge" style="font-weight: bold; margin-left: 5px;"></span></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<style>
.reviews-carousel {
    display: flex;
    overflow-x: auto;
    gap: 20px;
    padding-bottom: 20px;
    scroll-snap-type: x mandatory;
    scrollbar-width: thin;
    scrollbar-color: var(--primary) var(--bg-color);
}
.reviews-carousel::-webkit-scrollbar {
    height: 8px;
}
.reviews-carousel::-webkit-scrollbar-track {
    background: var(--bg-color);
    border-radius: 10px;
}
.reviews-carousel::-webkit-scrollbar-thumb {
    background: var(--primary);
    border-radius: 10px;
}
.review-card {
    background: var(--glass-bg);
    border: 1px solid var(--glass-border);
    border-radius: var(--border-radius);
    padding: 20px;
    min-width: 300px;
    max-width: 350px;
    flex-shrink: 0;
    scroll-snap-align: start;
    display: flex;
    flex-direction: column;
}
.review-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}
.reviewer-name {
    font-weight: bold;
    font-size: 1.1rem;
}
.review-rating {
    color: var(--warning);
    font-size: 1.2rem;
}
.review-text {
    color: var(--text-secondary);
    line-height: 1.6;
    flex-grow: 1;
    margin-bottom: 15px;
    font-size: 0.95rem;
}
.review-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.85rem;
    color: var(--text-secondary);
    border-top: 1px solid var(--glass-border);
    padding-top: 15px;
    margin-top: auto;
}
.review-source {
    display: flex;
    align-items: center;
    gap: 5px;
    font-weight: 500;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const appId = <?= (int)$app['id'] ?>;
    const container = document.getElementById('reviews-container');
    
    fetch('<?= BASE_URL ?>modules/apps/api_get_reviews.php?id=' + appId)
        .then(response => response.json())
        .then(data => {
            container.innerHTML = ''; // clear loading
            
            // Populate counts
            if (data.play_store_count !== undefined) {
                const badge = document.getElementById('play_count_badge');
                if (badge) badge.innerText = `(${data.play_store_count})`;
            }
            if (data.indus_store_count !== undefined) {
                const badge = document.getElementById('indus_count_badge');
                if (badge) badge.innerText = `(${data.indus_store_count})`;
            }
            
            if (data.success && data.reviews && data.reviews.length > 0) {
                data.reviews.forEach(review => {
                    const stars = Array(Math.floor(review.rating)).fill("<i class='bx bxs-star'></i>").join('') + 
                                  (review.rating % 1 !== 0 ? "<i class='bx bxs-star-half'></i>" : "");
                    
                    let sourceIcon = 'bx-store';
                    if (review.source.includes('Play Store')) sourceIcon = 'bxl-play-store';
                    
                    const dateHtml = review.date ? `<span>${review.date}</span>` : '<span></span>';
                    
                    const card = `
                        <div class="review-card">
                            <div class="review-header">
                                <div class="reviewer-name">${review.reviewer_name}</div>
                                <div class="review-rating">${stars}</div>
                            </div>
                            <div class="review-text">${review.review_text}</div>
                            <div class="review-footer">
                                ${dateHtml}
                                <span class="review-source"><i class='bx ${sourceIcon}'></i> ${review.source}</span>
                            </div>
                        </div>
                    `;
                    container.insertAdjacentHTML('beforeend', card);
                });
            } else {
                container.innerHTML = '<div style="padding: 20px; color: var(--text-secondary); border: 1px dashed var(--glass-border); border-radius: var(--border-radius); width: 100%;">No reviews available at this time.</div>';
            }
        })
        .catch(error => {
            console.error('Error fetching reviews:', error);
            container.innerHTML = '<div style="padding: 20px; color: var(--danger); border: 1px dashed var(--glass-border); border-radius: var(--border-radius); width: 100%;">Failed to load reviews.</div>';
        });
});
</script>

<?php require_once __DIR__ . '/../../templates/footer.php'; ?>
