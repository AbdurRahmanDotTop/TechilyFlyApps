<?php
// services.php
require_once __DIR__ . '/templates/header.php';

$pdo = getDBConnection();
$stmt = $pdo->query("SELECT * FROM services WHERE status = 'active' ORDER BY id ASC");
$services = $stmt->fetchAll();
?>

<section class="section pt-0">
    <div class="container">
        <div style="text-align: center; margin-bottom: 50px;">
            <h1 style="font-size: 2.5rem; margin-bottom: 15px;">Our Services</h1>
            <p style="color: var(--text-secondary); max-width: 600px; margin: 0 auto;">Discover the premium services we offer to help your business grow and succeed in the digital world.</p>
        </div>
        
        <?php if (count($services) > 0): ?>
            <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
                <?php foreach ($services as $service): ?>
                    <div class="app-card" style="text-align: center; padding: 40px 20px;">
                        <i class='bx <?= htmlspecialchars($service['icon']) ?>' style="font-size: 4rem; color: var(--accent-primary); margin-bottom: 20px;"></i>
                        <h3 style="font-size: 1.5rem; margin-bottom: 15px;"><?= htmlspecialchars($service['name']) ?></h3>
                        <p style="color: var(--text-secondary); line-height: 1.6;">
                            <?= nl2br(htmlspecialchars($service['description'])) ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 50px; color: var(--text-secondary);">
                <h2>New services coming soon!</h2>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once __DIR__ . '/templates/footer.php'; ?>
