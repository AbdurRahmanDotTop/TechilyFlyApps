<?php
// admin/apps/create.php
require_once __DIR__ . '/../includes/header.php';

$categories = $pdo->query("SELECT * FROM app_categories ORDER BY name ASC")->fetchAll();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    $category_id = $_POST['category_id'] ?? null;
    $developer = trim($_POST['developer'] ?? '');
    $version = trim($_POST['version'] ?? '');
    $play_store_rating = $_POST['play_store_rating'] ?? 0;
    $indus_store_rating = $_POST['indus_store_rating'] ?? 0;
    $play_store_version = trim($_POST['play_store_version'] ?? '');
    $indus_store_version = trim($_POST['indus_store_version'] ?? '');
    $play_store_downloads = $_POST['play_store_downloads'] ?? 0;
    $indus_store_downloads = $_POST['indus_store_downloads'] ?? 0;
    $logo_url = trim($_POST['logo_url'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $requirements = trim($_POST['requirements'] ?? '');
    $apk_download_link = trim($_POST['apk_download_link'] ?? '');
    $play_store_link = trim($_POST['play_store_link'] ?? '');
    $app_store_link = trim($_POST['app_store_link'] ?? '');
    $indus_store_link = trim($_POST['indus_store_link'] ?? '');
    $amazon_store_link = trim($_POST['amazon_store_link'] ?? '');
    $is_apk_active = isset($_POST['is_apk_active']) ? 1 : 0;
    $is_play_store_active = isset($_POST['is_play_store_active']) ? 1 : 0;
    $is_app_store_active = isset($_POST['is_app_store_active']) ? 1 : 0;
    $is_indus_store_active = isset($_POST['is_indus_store_active']) ? 1 : 0;
    $is_amazon_store_active = isset($_POST['is_amazon_store_active']) ? 1 : 0;
    $status = $_POST['status'] ?? 'draft';
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $publish_date = !empty($_POST['publish_date']) ? $_POST['publish_date'] : null;
    $app_update_date = !empty($_POST['app_update_date']) ? $_POST['app_update_date'] : null;

    if (empty($name) || empty($slug)) {
        $error = 'Name and Slug are required.';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO apps (category_id, name, slug, developer, version, play_store_rating, indus_store_rating, play_store_version, indus_store_version, play_store_downloads, indus_store_downloads, logo_url, description, requirements, apk_download_link, is_apk_active, play_store_link, is_play_store_active, app_store_link, is_app_store_active, indus_store_link, is_indus_store_active, amazon_store_link, is_amazon_store_active, status, is_featured, publish_date, app_update_date) VALUES (:category_id, :name, :slug, :developer, :version, :play_store_rating, :indus_store_rating, :play_store_version, :indus_store_version, :play_store_downloads, :indus_store_downloads, :logo_url, :description, :requirements, :apk_download_link, :is_apk_active, :play_store_link, :is_play_store_active, :app_store_link, :is_app_store_active, :indus_store_link, :is_indus_store_active, :amazon_store_link, :is_amazon_store_active, :status, :is_featured, :publish_date, :app_update_date)");
            
            $stmt->execute([
                ':category_id' => $category_id,
                ':name' => $name,
                ':slug' => $slug,
                ':developer' => $developer,
                ':version' => $version,
                ':play_store_rating' => $play_store_rating,
                ':indus_store_rating' => $indus_store_rating,
                ':play_store_version' => $play_store_version,
                ':indus_store_version' => $indus_store_version,
                ':play_store_downloads' => $play_store_downloads,
                ':indus_store_downloads' => $indus_store_downloads,
                ':logo_url' => $logo_url,
                ':description' => $description,
                ':requirements' => $requirements,
                ':apk_download_link' => $apk_download_link,
                ':is_apk_active' => $is_apk_active,
                ':play_store_link' => $play_store_link,
                ':is_play_store_active' => $is_play_store_active,
                ':app_store_link' => $app_store_link,
                ':is_app_store_active' => $is_app_store_active,
                ':indus_store_link' => $indus_store_link,
                ':is_indus_store_active' => $is_indus_store_active,
                ':amazon_store_link' => $amazon_store_link,
                ':is_amazon_store_active' => $is_amazon_store_active,
                ':status' => $status,
                ':is_featured' => $is_featured,
                ':publish_date' => $publish_date,
                ':app_update_date' => $app_update_date
            ]);
            
            $success = 'App created successfully!';
        } catch (PDOException $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1 style="margin: 0;">Add New App</h1>
    <a href="<?= BASE_URL ?>admin/apps/index.php" class="btn btn-outline"><i class='bx bx-arrow-back'></i> Back to Apps</a>
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
    <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);">App Name *</label>
            <input type="text" name="name" required style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-primary); color: var(--text-primary); outline: none;">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);">Slug (URL) *</label>
            <input type="text" name="slug" required style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-primary); color: var(--text-primary); outline: none;">
        </div>
    </div>
    
    <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);">Category</label>
            <select name="category_id" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-primary); color: var(--text-primary); outline: none;">
                <option value="">Select Category</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);">Developer</label>
            <input type="text" name="developer" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-primary); color: var(--text-primary); outline: none;">
        </div>
    </div>

    <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);">Fallback Version</label>
            <input type="text" name="version" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-primary); color: var(--text-primary); outline: none;">
        </div>
    </div>
    
    <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);">Play Store Version</label>
            <input type="text" name="play_store_version" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-primary); color: var(--text-primary); outline: none;">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);">Indus Store Version</label>
            <input type="text" name="indus_store_version" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-primary); color: var(--text-primary); outline: none;">
        </div>
    </div>
    
    <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);">Play Store Rating</label>
            <input type="number" step="0.1" name="play_store_rating" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-primary); color: var(--text-primary); outline: none;">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);">Indus Store Rating</label>
            <input type="number" step="0.1" name="indus_store_rating" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-primary); color: var(--text-primary); outline: none;">
        </div>
    </div>
    
    <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);">Play Store Downloads</label>
            <input type="number" name="play_store_downloads" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-primary); color: var(--text-primary); outline: none;">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);">Indus Store Downloads</label>
            <input type="number" name="indus_store_downloads" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-primary); color: var(--text-primary); outline: none;">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);">Logo URL</label>
            <input type="text" name="logo_url" placeholder="https://..." style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-primary); color: var(--text-primary); outline: none;">
        </div>
    </div>

    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);">Description</label>
        <textarea name="description" rows="5" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-primary); color: var(--text-primary); outline: none;"></textarea>
    </div>
    
    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);">Requirements</label>
        <textarea name="requirements" rows="3" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-primary); color: var(--text-primary); outline: none;"></textarea>
    </div>

    <h3 style="margin-top: 30px; margin-bottom: 15px; border-bottom: 1px solid var(--glass-border); padding-bottom: 10px;">Download Links</h3>
    <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
        <div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                <label style="color: var(--text-secondary); margin: 0;">APK Download Link</label>
                <label style="display: flex; align-items: center; gap: 5px; color: var(--text-primary); cursor: pointer; font-size: 0.9rem;">
                    <input type="checkbox" name="is_apk_active" value="1" checked> Active
                </label>
            </div>
            <input type="text" name="apk_download_link" placeholder="https://..." style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-primary); color: var(--text-primary); outline: none;">
        </div>
        <div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                <label style="color: var(--text-secondary); margin: 0;">Play Store Link</label>
                <label style="display: flex; align-items: center; gap: 5px; color: var(--text-primary); cursor: pointer; font-size: 0.9rem;">
                    <input type="checkbox" name="is_play_store_active" value="1" checked> Active
                </label>
            </div>
            <input type="text" name="play_store_link" placeholder="https://..." style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-primary); color: var(--text-primary); outline: none;">
        </div>
        <div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                <label style="color: var(--text-secondary); margin: 0;">App Store Link</label>
                <label style="display: flex; align-items: center; gap: 5px; color: var(--text-primary); cursor: pointer; font-size: 0.9rem;">
                    <input type="checkbox" name="is_app_store_active" value="1" checked> Active
                </label>
            </div>
            <input type="text" name="app_store_link" placeholder="https://..." style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-primary); color: var(--text-primary); outline: none;">
        </div>
        <div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                <label style="color: var(--text-secondary); margin: 0;">Indus Appstore Link</label>
                <label style="display: flex; align-items: center; gap: 5px; color: var(--text-primary); cursor: pointer; font-size: 0.9rem;">
                    <input type="checkbox" name="is_indus_store_active" value="1" checked> Active
                </label>
            </div>
            <input type="text" name="indus_store_link" placeholder="https://..." style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-primary); color: var(--text-primary); outline: none;">
        </div>
        <div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                <label style="color: var(--text-secondary); margin: 0;">Amazon Appstore Link</label>
                <label style="display: flex; align-items: center; gap: 5px; color: var(--text-primary); cursor: pointer; font-size: 0.9rem;">
                    <input type="checkbox" name="is_amazon_store_active" value="1" checked> Active
                </label>
            </div>
            <input type="text" name="amazon_store_link" placeholder="https://..." style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-primary); color: var(--text-primary); outline: none;">
        </div>
    </div>

    <h3 style="margin-top: 30px; margin-bottom: 15px; border-bottom: 1px solid var(--glass-border); padding-bottom: 10px;">Publishing & Dates</h3>
    <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);">Publish Date</label>
            <input type="date" name="publish_date" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-primary); color: var(--text-primary); outline: none;">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);">App Update Date</label>
            <input type="date" name="app_update_date" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-primary); color: var(--text-primary); outline: none;">
        </div>
    </div>
    
    <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);">Status</label>
            <select name="status" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-primary); color: var(--text-primary); outline: none;">
                <option value="draft">Draft</option>
                <option value="published">Published</option>
            </select>
        </div>
        <div style="margin-bottom: 15px; display: flex; align-items: center; margin-top: 30px;">
            <input type="checkbox" name="is_featured" id="is_featured" value="1" style="width: 20px; height: 20px; margin-right: 10px;">
            <label for="is_featured" style="color: var(--text-primary); cursor: pointer;">Feature this app on homepage</label>
        </div>
    </div>

    <div style="margin-top: 30px;">
        <button type="submit" class="btn btn-primary" style="padding: 15px 30px; font-size: 1.1rem;">Save App</button>
    </div>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
