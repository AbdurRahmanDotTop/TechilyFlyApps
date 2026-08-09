<?php
// admin/settings.php
require_once __DIR__ . '/includes/header.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $site_name = trim($_POST['site_name'] ?? '');
    $logo_url = trim($_POST['logo_url'] ?? '');
    $contact_email = trim($_POST['contact_email'] ?? '');
    $contact_phone = trim($_POST['contact_phone'] ?? '');
    $contact_address = trim($_POST['contact_address'] ?? '');
    $social_facebook = trim($_POST['social_facebook'] ?? '');
    $social_twitter = trim($_POST['social_twitter'] ?? '');
    $social_instagram = trim($_POST['social_instagram'] ?? '');
    $social_linkedin = trim($_POST['social_linkedin'] ?? '');
    $social_github = trim($_POST['social_github'] ?? '');
    
    if (empty($site_name)) {
        $error = 'Site Name is required.';
    } else {
        try {
            $stmt = $pdo->prepare("
                UPDATE website_settings SET 
                    site_name = :site_name,
                    logo_url = :logo_url,
                    contact_email = :contact_email,
                    contact_phone = :contact_phone,
                    contact_address = :contact_address,
                    social_facebook = :social_facebook,
                    social_twitter = :social_twitter,
                    social_instagram = :social_instagram,
                    social_linkedin = :social_linkedin,
                    social_github = :social_github
                WHERE id = 1
            ");
            
            $stmt->execute([
                ':site_name' => $site_name,
                ':logo_url' => $logo_url,
                ':contact_email' => $contact_email,
                ':contact_phone' => $contact_phone,
                ':contact_address' => $contact_address,
                ':social_facebook' => $social_facebook,
                ':social_twitter' => $social_twitter,
                ':social_instagram' => $social_instagram,
                ':social_linkedin' => $social_linkedin,
                ':social_github' => $social_github
            ]);
            
            $success = 'Settings updated successfully!';
        } catch (PDOException $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}

// Fetch current settings
$stmt = $pdo->query("SELECT * FROM website_settings WHERE id = 1 LIMIT 1");
$current_settings = $stmt->fetch();
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1 style="margin: 0;">Website Settings</h1>
</div>

<?php if ($error): ?>
    <div style="background: rgba(239, 68, 68, 0.1); color: var(--danger); padding: 15px; border-radius: 8px; margin-bottom: 20px;">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<?php if ($success): ?>
    <div style="background: rgba(16, 185, 129, 0.1); color: var(--success); padding: 15px; border-radius: 8px; margin-bottom: 20px;">
        <?= htmlspecialchars($success) ?>
    </div>
<?php endif; ?>

<form method="POST" action="" class="app-card" style="max-width: 800px;">
    <h3 style="margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1px solid var(--glass-border);">General Settings</h3>
    
    <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);">Site Name *</label>
            <input type="text" name="site_name" value="<?= htmlspecialchars($current_settings['site_name'] ?? '') ?>" required style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-primary); color: var(--text-primary); outline: none;">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);">Logo URL</label>
            <input type="text" name="logo_url" value="<?= htmlspecialchars($current_settings['logo_url'] ?? '') ?>" placeholder="https://..." style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-primary); color: var(--text-primary); outline: none;">
        </div>
    </div>
    
    <h3 style="margin-top: 30px; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1px solid var(--glass-border);">Contact Information</h3>
    
    <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);">Contact Email</label>
            <input type="email" name="contact_email" value="<?= htmlspecialchars($current_settings['contact_email'] ?? '') ?>" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-primary); color: var(--text-primary); outline: none;">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);">Contact Phone</label>
            <input type="text" name="contact_phone" value="<?= htmlspecialchars($current_settings['contact_phone'] ?? '') ?>" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-primary); color: var(--text-primary); outline: none;">
        </div>
    </div>
    
    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);">Contact Address</label>
        <textarea name="contact_address" rows="3" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-primary); color: var(--text-primary); outline: none;"><?= htmlspecialchars($current_settings['contact_address'] ?? '') ?></textarea>
    </div>
    
    <h3 style="margin-top: 30px; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1px solid var(--glass-border);">Social Links</h3>
    
    <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);">Facebook URL</label>
            <input type="text" name="social_facebook" value="<?= htmlspecialchars($current_settings['social_facebook'] ?? '') ?>" placeholder="https://facebook.com/..." style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-primary); color: var(--text-primary); outline: none;">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);">Twitter URL</label>
            <input type="text" name="social_twitter" value="<?= htmlspecialchars($current_settings['social_twitter'] ?? '') ?>" placeholder="https://twitter.com/..." style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-primary); color: var(--text-primary); outline: none;">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);">Instagram URL</label>
            <input type="text" name="social_instagram" value="<?= htmlspecialchars($current_settings['social_instagram'] ?? '') ?>" placeholder="https://instagram.com/..." style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-primary); color: var(--text-primary); outline: none;">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);">LinkedIn URL</label>
            <input type="text" name="social_linkedin" value="<?= htmlspecialchars($current_settings['social_linkedin'] ?? '') ?>" placeholder="https://linkedin.com/in/..." style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-primary); color: var(--text-primary); outline: none;">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);">GitHub URL</label>
            <input type="text" name="social_github" value="<?= htmlspecialchars($current_settings['social_github'] ?? '') ?>" placeholder="https://github.com/..." style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-primary); color: var(--text-primary); outline: none;">
        </div>
    </div>
    
    <div style="margin-top: 30px;">
        <button type="submit" class="btn btn-primary" style="padding: 15px 30px; font-size: 1.1rem;">Save Settings</button>
    </div>
</form>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
