<?php
$adminPageTitle = 'Website Maintenance';
require __DIR__ . '/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$errors = [];
$success = '';

if (isset($_SESSION['maintenance_success'])) {
    $success = $_SESSION['maintenance_success'];
    unset($_SESSION['maintenance_success']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $maintenance_mode = $_POST['maintenance_mode'] ?? '0';
    $maintenance_title = trim($_POST['maintenance_title'] ?? '');
    $maintenance_message = trim($_POST['maintenance_message'] ?? '');

    if ($maintenance_title === '') {
        $errors[] = 'Maintenance Title cannot be empty.';
    } else {
        try {
            $stmt = $pdo->prepare("UPDATE `site_settings` SET `setting_value` = ? WHERE `setting_key` = ?");
            
            // Check if settings exist first to prevent failed updates
            $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM `site_settings` WHERE `setting_key` = ?");
            
            $settingsList = [
                'maintenance_mode' => $maintenance_mode,
                'maintenance_title' => $maintenance_title,
                'maintenance_message' => $maintenance_message
            ];
            
            foreach ($settingsList as $key => $val) {
                $checkStmt->execute([$key]);
                if ($checkStmt->fetchColumn() > 0) {
                    $stmt->execute([$val, $key]);
                } else {
                    $insertStmt = $pdo->prepare("INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES (?, ?)");
                    $insertStmt->execute([$key, $val]);
                }
            }
            
            $_SESSION['maintenance_success'] = 'Maintenance settings updated successfully.';
            header('Location: maintenance.php');
            exit;
        } catch (Throwable $e) {
            $errors[] = 'Unable to update maintenance settings: ' . $e->getMessage();
        }
    }
}

// Load current settings from database
$settings = [];
try {
    $stmt = $pdo->query("SELECT `setting_key`, `setting_value` FROM `site_settings`");
    while ($row = $stmt->fetch()) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
} catch (Throwable $e) {
    $errors[] = 'Database settings could not be fetched.';
}

$maintenance_mode = $settings['maintenance_mode'] ?? '0';
$maintenance_title = $settings['maintenance_title'] ?? 'Scheduled Maintenance';
$maintenance_message = $settings['maintenance_message'] ?? '';

include __DIR__ . '/header.php';
?>

<section class="admin-form-card">
    <div class="form-card-header">
        <span class="admin-eyebrow">Preferences</span>
        <h2>Website Maintenance</h2>
        <p>Temporarily put the live website under maintenance mode. Logged-in administrators will still be able to preview and test the live website pages.</p>
    </div>

    <?php if ($success !== ''): ?>
        <div class="alert success-alert"><?php echo htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?></div>
    <?php endif; ?>

    <?php if ($errors): ?>
        <div class="alert">
            <?php foreach ($errors as $error): ?>
                <div><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post" class="admin-form">
        <div class="form-group" style="padding-bottom: 12px; border-bottom: 1px solid var(--line); margin-bottom: 20px;">
            <label style="margin-bottom: 12px;">Maintenance Mode Status</label>
            <div style="display: flex; gap: 24px; align-items: center; margin-top: 8px;">
                <label style="display: inline-flex; align-items: center; gap: 10px; cursor: pointer; font-weight: 700; color: #eff8ef; margin: 0;">
                    <input type="radio" name="maintenance_mode" value="1" <?php echo $maintenance_mode === '1' ? 'checked' : ''; ?> style="width: 20px; height: 20px; accent-color: #ff6b6b; cursor: pointer; margin: 0;">
                    <span style="display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; border-radius: 999px; background: rgba(255, 107, 107, 0.15); border: 1px solid rgba(255, 107, 107, 0.3); color: #ff8b8b; font-size: 0.85rem;">
                        <i class="fa-solid fa-power-off"></i> Enabled &mdash; Under Maintenance
                    </span>
                </label>
                <label style="display: inline-flex; align-items: center; gap: 10px; cursor: pointer; font-weight: 700; color: #eff8ef; margin: 0;">
                    <input type="radio" name="maintenance_mode" value="0" <?php echo $maintenance_mode === '0' ? 'checked' : ''; ?> style="width: 20px; height: 20px; accent-color: #2fc46f; cursor: pointer; margin: 0;">
                    <span style="display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; border-radius: 999px; background: rgba(47, 196, 111, 0.15); border: 1px solid rgba(47, 196, 111, 0.3); color: #7cf4ab; font-size: 0.85rem;">
                        <i class="fa-solid fa-circle-check"></i> Disabled &mdash; Website Live
                    </span>
                </label>
            </div>
            <p style="margin-top: 10px; font-size: 0.85rem; color: var(--muted);">When enabled, visitors will see the maintenance screen with custom title and message instead of normal pages.</p>
        </div>

        <div class="form-group">
            <label for="maintenance_title">Maintenance Title</label>
            <input type="text" id="maintenance_title" name="maintenance_title" placeholder="Enter page headline" value="<?php echo htmlspecialchars($maintenance_title, ENT_QUOTES, 'UTF-8'); ?>" required>
            <p style="margin-top: 6px; font-size: 0.82rem; color: var(--muted);">This is the main headline displayed on the maintenance screen.</p>
        </div>

        <div class="form-group">
            <label for="maintenance_message">Maintenance Message</label>
            <textarea id="maintenance_message" name="maintenance_message" placeholder="Enter message for website visitors describing the maintenance details" required rows="5"><?php echo htmlspecialchars($maintenance_message, ENT_QUOTES, 'UTF-8'); ?></textarea>
            <p style="margin-top: 6px; font-size: 0.82rem; color: var(--muted);">Provide context to your visitors (e.g., expected duration or updates being performed).</p>
        </div>

        <div class="form-actions">
            <button type="submit" class="admin-submit-btn">
                <i class="fa-solid fa-floppy-disk"></i> Save Settings
            </button>
            <a href="index.php" class="admin-cancel-btn">Cancel</a>
        </div>
    </form>
</section>

<?php include __DIR__ . '/footer.php'; ?>
