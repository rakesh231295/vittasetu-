<?php
$slug = trim($_GET['slug'] ?? '');
$blog = null;
$relatedBlogs = [];
$page_title = 'Vittasetu | Blog Detail';

try {
    require __DIR__ . '/db.php';

    if ($slug !== '') {
        $stmt = $pdo->prepare(
            "SELECT blogs.*, blog_categories.name AS category_name
            FROM blogs
            LEFT JOIN blog_categories ON blog_categories.id = blogs.category_id
            WHERE blogs.slug = ? AND blogs.status = 'published'
            LIMIT 1"
        );
        $stmt->execute([$slug]);
        $blog = $stmt->fetch();
    }

    if ($blog) {
        $page_title = $blog['meta_title'] ?: $blog['title'] . ' | Vittasetu';

        $relatedStmt = $pdo->prepare(
            "SELECT id, title, slug, short_description, image
            FROM blogs
            WHERE status = 'published' AND id != ? AND category_id <=> ?
            ORDER BY published_at DESC, id DESC
            LIMIT 3"
        );
        $relatedStmt->execute([(int) $blog['id'], $blog['category_id']]);
        $relatedBlogs = $relatedStmt->fetchAll();
    }
} catch (Throwable $e) {
    $blog = null;
    $relatedBlogs = [];
}

include __DIR__ . '/header.php';
?>

<main id="top" class="landing-page inner-page">
    <section class="section page-hero">
        <div class="page-hero-banner">
            <img src="<?php echo htmlspecialchars($blog['image'] ?? 'img/3.jpg', ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($blog['title'] ?? 'Blog detail', ENT_QUOTES, 'UTF-8'); ?>">
            <div class="page-hero-overlay">
                <div class="container">
                    <div class="page-hero-center">
                        <h1><?php echo htmlspecialchars($blog['title'] ?? 'Blog Not Found', ENT_QUOTES, 'UTF-8'); ?></h1>
                        <div class="page-crumbs">
                            <a href="index.php">Home</a>
                            <span>&gt;</span>
                            <a href="blog.php">Blog</a>
                            <span>&gt;</span>
                            <span><?php echo htmlspecialchars($blog['category_name'] ?? 'Detail', ENT_QUOTES, 'UTF-8'); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <?php if ($blog): ?>
                <article class="card blog-detail-card" style="padding:36px;">
                    <div class="blog-detail-meta" style="display:flex; flex-wrap:wrap; gap:12px; margin-bottom:22px;">
                        <span class="info-chip"><?php echo htmlspecialchars($blog['category_name'] ?? 'Blog', ENT_QUOTES, 'UTF-8'); ?></span>
                        <?php if (!empty($blog['published_at'])): ?>
                            <span class="info-chip"><?php echo date('d M Y', strtotime($blog['published_at'])); ?></span>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($blog['image'])): ?>
                        <div class="media-frame blog-detail-image" style="margin-bottom:28px; max-height:420px; overflow:hidden;">
                            <img src="<?php echo htmlspecialchars($blog['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($blog['title'], ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                    <?php endif; ?>

                    <div class="section-title" style="margin-bottom:20px;">
                        <span class="eyebrow">Vittasetu Insights</span>
                        <h2><?php echo htmlspecialchars($blog['title'], ENT_QUOTES, 'UTF-8'); ?></h2>
                        <?php if (!empty($blog['short_description'])): ?>
                            <p><?php echo htmlspecialchars($blog['short_description'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="blog-detail-content" style="color:var(--muted); line-height:1.9; font-size:1.02rem;">
                        <?php
                        echo strip_tags(
                            $blog['description'],
                            '<p><br><strong><b><em><i><ul><ol><li><h2><h3><h4><blockquote><a>'
                        );
                        ?>
                    </div>
                </article>

                <?php if ($relatedBlogs): ?>
                    <div class="section-title section-title-center" style="margin-top:64px;">
                        <span class="eyebrow">Related Blogs</span>
                        <h2>More insights you may like</h2>
                    </div>

                    <div class="blog-grid resources-grid">
                        <?php foreach ($relatedBlogs as $related): ?>
                            <article class="card blog-card">
                                <div class="media-frame blog-card-media">
                                    <img src="<?php echo htmlspecialchars($related['image'] ?: 'img/7.jpg', ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($related['title'], ENT_QUOTES, 'UTF-8'); ?>">
                                </div>
                                <div class="blog-card-content">
                                    <span class="info-chip">Related</span>
                                    <h3><?php echo htmlspecialchars($related['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
                                    <p><?php echo htmlspecialchars($related['short_description'] ?: 'Read more financial insights from Vittasetu.', ENT_QUOTES, 'UTF-8'); ?></p>
                                    <a href="blog-detail.php?slug=<?php echo urlencode($related['slug']); ?>" class="blog-readmore">Read More</a>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="card" style="padding:36px; text-align:center;">
                    <span class="eyebrow">Blog Not Found</span>
                    <h2 style="margin-top:12px;">The blog you are looking for is not available</h2>
                    <p>Please go back to the blog page and choose another article.</p>
                    <div class="hero-actions" style="justify-content:center; margin-top:24px;">
                        <a href="blog.php" class="btn btn-primary">Back to Blog</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php include __DIR__ . '/footer.php'; ?>
