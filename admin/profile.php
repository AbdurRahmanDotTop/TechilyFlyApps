<?php
// admin/profile.php
require_once __DIR__ . '/includes/header.php';

$error = '';
$success = '';

// Get current admin details
$admin_id = $_SESSION['admin_id'];
$stmt = $pdo->prepare("SELECT * FROM admins WHERE id = ?");
$stmt->execute([$admin_id]);
$current_admin = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($username)) {
        $error = 'Username is required.';
    } elseif (!empty($new_password) && $new_password !== $confirm_password) {
        $error = 'New password and confirm password do not match.';
    } else {
        // Check if username is already taken by another admin
        $checkStmt = $pdo->prepare("SELECT id FROM admins WHERE username = ? AND id != ?");
        $checkStmt->execute([$username, $admin_id]);
        if ($checkStmt->fetch()) {
            $error = 'This username is already taken.';
        } else {
            try {
                if (!empty($new_password)) {
                    // Update all including password
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                    $updateStmt = $pdo->prepare("UPDATE admins SET username = ?, email = ?, phone = ?, password_hash = ? WHERE id = ?");
                    $updateStmt->execute([$username, $email, $phone, $password_hash, $admin_id]);
                } else {
                    // Update only profile details
                    $updateStmt = $pdo->prepare("UPDATE admins SET username = ?, email = ?, phone = ? WHERE id = ?");
                    $updateStmt->execute([$username, $email, $phone, $admin_id]);
                }

                // Update session if username changed
                $_SESSION['admin_username'] = $username;
                
                $success = 'Profile updated successfully!';
                
                // Refresh current admin data for the form
                $stmt->execute([$admin_id]);
                $current_admin = $stmt->fetch(PDO::FETCH_ASSOC);
                
            } catch (PDOException $e) {
                $error = 'Database error: ' . $e->getMessage();
            }
        }
    }
}
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1 style="margin: 0;">Admin Profile</h1>
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
    <h3 style="margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1px solid var(--glass-border);">Personal Information</h3>
    
    <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);">Username *</label>
            <input type="text" name="username" value="<?= htmlspecialchars($current_admin['username'] ?? '') ?>" required style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-primary); color: var(--text-primary); outline: none;">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);">Email Address</label>
            <input type="email" name="email" value="<?= htmlspecialchars($current_admin['email'] ?? '') ?>" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-primary); color: var(--text-primary); outline: none;">
        </div>
    </div>

    <div style="margin-bottom: 25px;">
        <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);">Phone Number</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($current_admin['phone'] ?? '') ?>" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-primary); color: var(--text-primary); outline: none;">
    </div>

    <h3 style="margin-top: 30px; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1px solid var(--glass-border);">Update Password</h3>
    <p style="color: var(--text-secondary); margin-bottom: 20px; font-size: 0.9rem;">Leave fields blank if you do not want to change your password.</p>

    <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);">New Password</label>
            <input type="password" name="new_password" placeholder="Enter new password" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-primary); color: var(--text-primary); outline: none;">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);">Confirm New Password</label>
            <input type="password" name="confirm_password" placeholder="Re-enter new password" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-primary); color: var(--text-primary); outline: none;">
        </div>
    </div>
    
    <div style="margin-top: 30px;">
        <button type="submit" class="btn btn-primary" style="padding: 15px 30px; font-size: 1.1rem;"><i class='bx bx-save'></i> Update Profile</button>
    </div>
</form>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
