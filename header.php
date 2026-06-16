<?php
$page_title = $page_title ?? 'Vittasetu | Smart Loan Solutions';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Vittasetu Services Private Limited provides financial advisory, funding solutions, virtual CFO, wealth management, project finance, and business consulting services.">
    <meta name="keywords" content="Vittasetu, financial advisory, funding solutions, loan advisory, virtual CFO, project finance, wealth management, business consulting">
    <meta name="author" content="Vittasetu Services Private Limited">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="<?php echo htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:description" content="Trusted financial advisory and funding solutions for businesses, professionals, startups, and individuals.">
    <meta property="og:type" content="website">
    <meta property="og:image" content="img/v-logo-removebg-preview.png">
    <meta name="twitter:card" content="summary_large_image">
    <title><?php echo htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="icon" type="image/png" href="img/v-logo-removebg-preview.png">
    <link rel="apple-touch-icon" href="img/v-logo-removebg-preview.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="announce-bar">
    <div class="container announce-bar-inner">
        <span><i class="fa-solid fa-circle-check"></i> RBI Registered Partners</span>
        <span class="announce-divider">|</span>
        <span><i class="fa-solid fa-phone"></i> <a href="tel:+919831040460">+91 9831040460</a></span>
        <span class="announce-divider">|</span>
        <span><i class="fa-solid fa-envelope"></i> <a href="mailto:contact@vittasetu.co.in">contact@vittasetu.co.in</a></span>
    </div>
</div>
<header class="site-header">
    <div class="container header-wrap">
        <a href="index.php" class="brand" aria-label="Vittasetu home">
            <span class="brand-mark brand-logo-img"><img src="img/v-logo-removebg-preview.png" alt="Vittasetu logo"></span>
        </a>
        <nav class="site-nav" aria-label="Primary navigation">
            <a href="about.php">About</a>
            <div class="nav-dropdown">
                <a href="products.php" class="nav-dropdown-toggle">Products <i class="fa-solid fa-chevron-down"></i></a>
                <div class="nav-dropdown-menu">
                    <a href="products.php">All Services</a>
                    <a href="financial-consulting.php">Financial Consulting</a>
                    <a href="funding-solutions.php">Funding Solutions</a>
                    <a href="investment-wealth-management.php">Investment &amp; Wealth Management</a>
                    <a href="internal-audits-compliance.php">Internal Audits &amp; Compliance</a>
                    <a href="bookkeeping-financial-modelling.php">Bookkeeping &amp; Financial Modelling</a>
                    <a href="virtual-services.php">Virtual CFO Services</a>
                    <a href="financial-health-report.php">Financial Health Report</a>
                </div>
            </div>
            <a href="calculator.php">Calculator</a>
            <a href="blog.php">Blog</a>
            <!-- <a href="#testimonials">Testimonials</a> -->
            <a href="contact.php">Contact</a>
        </nav>
        <button class="menu-toggle" type="button" aria-label="Open menu" aria-expanded="false" data-menu-toggle>
            <span></span>
            <span></span>
            <span></span>
        </button>
        <a href="#apply" class="nav-cta">Apply Now</a>
    </div>
    <div class="mobile-menu" data-mobile-menu>
        <div class="container mobile-menu-inner">
            <a href="about.php">About</a>
            <a href="products.php">Products</a>
            <a href="financial-consulting.php" class="mobile-sub-link">Financial Consulting</a>
            <a href="funding-solutions.php" class="mobile-sub-link">Funding Solutions</a>
            <a href="investment-wealth-management.php" class="mobile-sub-link">Investment &amp; Wealth Management</a>
            <a href="internal-audits-compliance.php" class="mobile-sub-link">Internal Audits &amp; Compliance</a>
            <a href="bookkeeping-financial-modelling.php" class="mobile-sub-link">Bookkeeping &amp; Financial Modelling</a>
            <a href="virtual-services.php" class="mobile-sub-link">Virtual CFO Services</a>
            <a href="financial-health-report.php" class="mobile-sub-link">Financial Health Report</a>
            <a href="calculator.php">Calculator</a>
            <a href="blog.php">Blog</a>
            <a href="contact.php">Contact</a>
            <a href="index.php#apply" class="mobile-menu-cta">Apply Now</a>
        </div>
    </div>
</header>
