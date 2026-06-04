<?php
$adminPageTitle = 'Change Password';
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

if (isset($_SESSION['change_password_errors'])) {
    $errors = $_SESSION['change_password_errors'];
    unset($_SESSION['change_password_errors']);
}

if (isset($_SESSION['change_password_success'])) {
    $success = $_SESSION['change_password_success'];
    unset($_SESSION['change_password_success']);
}

if (isset($_GET['success']) && $_GET['success'] === '1') {
    $success = 'Password changed successfully.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if ($currentPassword === '' || $newPassword === '' || $confirmPassword === '') {
        $errors[] = 'Please fill in all password fields.';
    } elseif (strlen($newPassword) < 6) {
        $errors[] = 'New password must be at least 6 characters long.';
    } elseif ($newPassword !== $confirmPassword) {
        $errors[] = 'New password and confirm password do not match.';
    } else {
        try {
            $stmt = $pdo->prepare('SELECT id, password FROM admin_users WHERE id = ? LIMIT 1');
            $stmt->execute([(int) $_SESSION['admin_id']]);
            $admin = $stmt->fetch();

            if (!$admin || !password_verify($currentPassword, $admin['password'])) {
                $errors[] = 'Current password is incorrect.';
            } else {
                $updateStmt = $pdo->prepare('UPDATE admin_users SET password = ? WHERE id = ?');
                $updateStmt->execute([password_hash($newPassword, PASSWORD_DEFAULT), (int) $_SESSION['admin_id']]);
                $_SESSION['change_password_success'] = 'Password changed successfully.';
            }
        } catch (Throwable $e) {
            $errors[] = 'Unable to change password right now.';
        }
    }

    if ($errors) {
        $_SESSION['change_password_errors'] = $errors;
    }

    header('Location: change-password.php');
    exit;
}

include __DIR__ . '/header.php';
?>

<section class="admin-form-card">
    <div class="form-card-header">
        <span class="admin-eyebrow">Security</span>
        <h2>Change Password</h2>
        <p>Update your admin account password securely.</p>
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
        <div class="form-group">
            <label for="current_password">Current Password</label>
            <div class="password-field">
                <input type="password" id="current_password" name="current_password" placeholder="Enter current password" required>
                <button type="button" class="password-toggle" data-password-toggle="current_password"><i class="fa-solid fa-eye"></i></button>
            </div>
        </div>

        <div class="form-group">
            <label for="new_password">New Password</label>
            <div class="password-field">
                <input type="password" id="new_password" name="new_password" placeholder="Enter new password" required>
                <button type="button" class="password-toggle" data-password-toggle="new_password"><i class="fa-solid fa-eye"></i></button>
            </div>
        </div>

        <div class="form-group">
            <label for="confirm_password">Confirm New Password</label>
            <div class="password-field">
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm new password" required>
                <button type="button" class="password-toggle" data-password-toggle="confirm_password"><i class="fa-solid fa-eye"></i></button>
            </div>
        </div>

        <button type="submit" class="submit-btn password-submit">Update Password</button>
    </form>
</section>

<script>
    document.querySelectorAll('[data-password-toggle]').forEach(function (button) {
        button.addEventListener('click', function () {
            var input = document.getElementById(button.getAttribute('data-password-toggle'));
            var icon = button.querySelector('i');

            if (!input) {
                return;
            }

            input.type = input.type === 'password' ? 'text' : 'password';
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
    });
</script>

<?php include __DIR__ . '/footer.php'; ?>
