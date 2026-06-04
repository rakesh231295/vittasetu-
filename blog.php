<?php
$page_title = 'Vittasetu | Blog & Resources';
$blogs = [];
$categories = [];
$selectedCategory = trim($_GET['category'] ?? '');

try {
    require __DIR__ . '/db.php';

    $categoryStmt = $pdo->query(
        "SELECT DISTINCT blog_categories.name, blog_categories.slug
        FROM blog_categories
        INNER JOIN blogs ON blogs.category_id = blog_categories.id
        WHERE blogs.status = 'published' AND blog_categories.status = 1
        ORDER BY blog_categories.name ASC"
    );
    $categories = $categoryStmt->fetchAll();

    $sql = "SELECT blogs.*, blog_categories.name AS category_name, blog_categories.slug AS category_slug
        FROM blogs
        LEFT JOIN blog_categories ON blog_categories.id = blogs.category_id
        WHERE blogs.status = 'published'";
    $params = [];

    if ($selectedCategory !== '') {
        $sql .= ' AND blog_categories.slug = ?';
        $params[] = $selectedCategory;
    }

    $sql .= ' ORDER BY blogs.published_at DESC, blogs.id DESC';

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $blogs = $stmt->fetchAll();
} catch (Throwable $e) {
    $blogs = [];
    $categories = [];
}

include __DIR__ . '/header.php';
?>

<main id="top" class="landing-page inner-page">
    <section class="section page-hero">
        <div class="page-hero-banner">
            <img src="img/3.jpg" alt="Vittasetu financial blog insights">
            <div class="page-hero-overlay">
                <div class="container">
                    <div class="page-hero-center">
                        <h1>Blog &amp; Resources</h1>
                        <div class="page-crumbs">
                            <a href="index.php">Home</a>
                            <span>&gt;</span>
                            <span>Blog &amp; Resources</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="section-title section-title-center">
                <span class="eyebrow">Blog / Resources Page</span>
                <h2>Stay updated with the latest financial insights, loan guides, and investment strategies</h2>
                <p>Explore expert-written blogs on financial consulting, business loans, investment strategies, and wealth management.</p>
            </div>

            <?php if ($categories): ?>
                <div class="blog-filter">
                    <a href="blog.php" class="<?php echo $selectedCategory === '' ? 'active' : ''; ?>">All</a>
                    <?php foreach ($categories as $category): ?>
                        <a href="blog.php?category=<?php echo urlencode($category['slug']); ?>" class="<?php echo $selectedCategory === $category['slug'] ? 'active' : ''; ?>">
                            <?php echo htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8'); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ($blogs): ?>
                <div class="blog-grid resources-grid">
                    <?php foreach ($blogs as $blog): ?>
                        <article class="card blog-card">
                            <div class="media-frame blog-card-media">
                                <img src="<?php echo htmlspecialchars($blog['image'] ?: 'img/7.jpg', ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($blog['title'], ENT_QUOTES, 'UTF-8'); ?>">
                            </div>
                            <div class="blog-card-content">
                                <span class="info-chip"><?php echo htmlspecialchars($blog['category_name'] ?? 'Blog', ENT_QUOTES, 'UTF-8'); ?></span>
                                <h3><?php echo htmlspecialchars($blog['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
                                <p><?php echo htmlspecialchars($blog['short_description'] ?: substr(strip_tags($blog['description']), 0, 140), ENT_QUOTES, 'UTF-8'); ?></p>
                                <a href="blog-detail.php?slug=<?php echo urlencode($blog['slug']); ?>" class="blog-readmore">Read More</a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="card" style="padding:32px; text-align:center;">
                    <span class="eyebrow">No Blogs Found</span>
                    <h3 style="margin-top:10px;">No blogs found</h3>
                    <p>Please choose another category or check back later for financial insights and resources.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="card cta-panel" style="padding:36px; overflow:hidden; position:relative;">
                <div class="grid-2 cta-layout" style="align-items:center;">
                    <div class="cta-copy">
                        <span class="eyebrow">Need Expert Guidance?</span>
                        <h2>Turn financial information into confident decisions</h2>
                        <p>Connect with Vittasetu for guidance on consulting, business loans, investment strategies, and wealth management.</p>
                        <div class="hero-actions" style="margin-top:24px;">
                            <a href="contact.php" class="btn btn-primary">Contact Us</a>
                            <a href="products.php" class="btn btn-secondary">View Services</a>
                        </div>
                    </div>
                    <div class="media-frame cta-main-media">
                        <img src="img/2.jpg" alt="Financial advice and support">
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/footer.php'; ?>
