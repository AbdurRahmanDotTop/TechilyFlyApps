<?php
// page.php
require_once __DIR__ . '/templates/header.php';

$slug = '';
if (isset($_SERVER['PATH_INFO']) && !empty(trim($_SERVER['PATH_INFO'], '/'))) {
    $slug = trim($_SERVER['PATH_INFO'], '/');
} else {
    $slug = $_GET['slug'] ?? 'coming-soon';
}

$titles = [
    'privacy-policy' => 'Privacy Policy',
    'terms-conditions' => 'Terms & Conditions',
    'refund-policy' => 'Refund Policy',
    'faq' => 'Frequently Asked Questions',
    'portfolio' => 'Our Portfolio',
    'pricing' => 'Pricing Plans'
];

$title = $titles[$slug] ?? 'Page Under Construction';
?>

<section class="section">
    <div class="container" style="text-align: center; max-width: 600px;">
        <i class='bx bx-file' style="font-size: 5rem; color: var(--accent-primary); margin-bottom: 20px;"></i>
        <h1 style="margin-bottom: 20px; font-size: 2.5rem;"><?= htmlspecialchars($title) ?></h1>
        <p style="color: var(--text-secondary); line-height: 1.8; font-size: 1.1rem;">
            This page is currently being updated. Please check back later for the latest information.
        </p>
        <div style="margin-top: 30px;">
            <a href="<?= BASE_URL ?>index.php" class="btn btn-primary">Return to Home</a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/templates/footer.php'; ?>
