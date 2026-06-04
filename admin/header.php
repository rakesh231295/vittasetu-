<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$adminPageTitle = $adminPageTitle ?? 'Dashboard';
$currentPage = basename($_SERVER['PHP_SELF']);
$adminName = $_SESSION['admin_name'] ?? 'Admin';
$adminBasePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($adminPageTitle, ENT_QUOTES, 'UTF-8'); ?> | Vittasetu Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo htmlspecialchars($adminBasePath, ENT_QUOTES, 'UTF-8'); ?>/css/style.css?v=6">
</head>
<body class="admin-page">
    <aside class="admin-sidebar">
        <div class="sidebar-glow"></div>
        <a href="index.php" class="admin-logo">
            <span class="brand-mark brand-logo-img"><img src="../img/v-logo-removebg-preview.png" alt="Vittasetu logo"></span>
        </a>

        <span class="admin-nav-label">Main Menu</span>
        <nav class="admin-nav" aria-label="Admin navigation">
            <a href="index.php" class="<?php echo $currentPage === 'index.php' ? 'active' : ''; ?>">
                <i class="fa-solid fa-gauge-high"></i>
                <span>Dashboard</span>
            </a>
            <a href="add-blog.php" class="<?php echo $currentPage === 'add-blog.php' ? 'active' : ''; ?>">
                <i class="fa-solid fa-pen-to-square"></i>
                <span>Add Blog</span>
            </a>
            <a href="list-blog.php" class="<?php echo $currentPage === 'list-blog.php' ? 'active' : ''; ?>">
                <i class="fa-solid fa-newspaper"></i>
                <span>Blog List</span>
            </a>
            <a href="create-category.php" class="<?php echo $currentPage === 'create-category.php' ? 'active' : ''; ?>">
                <i class="fa-solid fa-folder-plus"></i>
                <span>Add Category</span>
            </a>
            <a href="category.php" class="<?php echo $currentPage === 'category.php' ? 'active' : ''; ?>">
                <i class="fa-solid fa-layer-group"></i>
                <span>Categories</span>
            </a>
            <a href="contact-details.php" class="<?php echo $currentPage === 'contact-details.php' ? 'active' : ''; ?>">
                <i class="fa-solid fa-address-book"></i>
                <span>Contact Enquiries</span>
            </a>
            <a href="lead.php" class="<?php echo $currentPage === 'lead.php' ? 'active' : ''; ?>">
                <i class="fa-solid fa-user-check"></i>
                <span>Leads</span>
            </a>
            <a href="change-password.php" class="<?php echo $currentPage === 'change-password.php' ? 'active' : ''; ?>">
                <i class="fa-solid fa-key"></i>
                <span>Change Password</span>
            </a>
            <a href="../index.php" target="_blank">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                <span>View Website</span>
            </a>
        </nav>

        <div class="admin-sidebar-footer">
            <div class="admin-user">
                <span class="admin-user-avatar"><i class="fa-solid fa-user"></i></span>
                <span>
                    <strong><?php echo htmlspecialchars($adminName, ENT_QUOTES, 'UTF-8'); ?></strong>
                    <small>Administrator</small>
                </span>
            </div>
            <a href="logout.php" class="logout-link">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Logout</span>
            </a>
        </div>
    </aside>

    <main class="admin-main">
        <header class="admin-topbar">
            <div>
                <span class="admin-eyebrow">Vittasetu Admin</span>
                <h1><?php echo htmlspecialchars($adminPageTitle, ENT_QUOTES, 'UTF-8'); ?></h1>
                <p>Manage website blogs, categories, and publishing workflow.</p>
            </div>
            <div class="admin-topbar-actions">
                <a href="add-blog.php" class="admin-topbar-btn primary">
                    <i class="fa-solid fa-plus"></i>
                    New Blog
                </a>
                <a href="../index.php" target="_blank" class="admin-topbar-btn">
                    <i class="fa-solid fa-globe"></i>
                    Website
                </a>
            </div>
        </header>
