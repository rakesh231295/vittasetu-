<?php
$adminPageTitle = 'Blog List';
require __DIR__ . '/db.php';

$success = '';
$errors = [];
$perPage = 6;
$currentPageNumber = max(1, (int) ($_GET['page'] ?? 1));
$offset = ($currentPageNumber - 1) * $perPage;
$totalBlogs = 0;
$totalPages = 1;

if (isset($_GET['delete'])) {
    $deleteId = (int) $_GET['delete'];

    if ($deleteId > 0) {
        try {
            $imageStmt = $pdo->prepare('SELECT image FROM blogs WHERE id = ? LIMIT 1');
            $imageStmt->execute([$deleteId]);
            $blogImage = $imageStmt->fetchColumn();

            $deleteStmt = $pdo->prepare('DELETE FROM blogs WHERE id = ?');
            $deleteStmt->execute([$deleteId]);

            if ($blogImage && str_starts_with($blogImage, 'uploads/blogs/')) {
                $imagePath = dirname(__DIR__) . '/' . $blogImage;

                if (is_file($imagePath)) {
                    unlink($imagePath);
                }
            }

            $success = 'Blog deleted successfully.';
        } catch (Throwable $e) {
            $errors[] = 'Unable to delete blog.';
        }
    }
}

try {
    $totalBlogs = (int) $pdo->query('SELECT COUNT(*) FROM blogs')->fetchColumn();
    $totalPages = max(1, (int) ceil($totalBlogs / $perPage));

    if ($currentPageNumber > $totalPages) {
        $currentPageNumber = $totalPages;
        $offset = ($currentPageNumber - 1) * $perPage;
    }

    $stmt = $pdo->prepare(
        'SELECT blogs.*, blog_categories.name AS category_name
        FROM blogs
        LEFT JOIN blog_categories ON blog_categories.id = blogs.category_id
        ORDER BY blogs.id DESC
        LIMIT :limit OFFSET :offset'
    );
    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $blogs = $stmt->fetchAll();
} catch (Throwable $e) {
    $blogs = [];
    $errors[] = 'Unable to load blogs. Please check blogs table.';
}

include __DIR__ . '/header.php';
?>

<section class="admin-table-card">
    <div class="table-header">
        <div>
            <span class="admin-eyebrow">All Posts</span>
            <h2>Manage Blog Posts</h2>
            <p>View, edit, publish status, and delete blog posts.</p>
        </div>
        <a href="add-blog.php" class="admin-submit-btn"><i class="fa-solid fa-plus"></i> Add Blog</a>
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

    <?php if ($blogs): ?>
        <div class="blog-list-grid">
            <?php foreach ($blogs as $blog): ?>
                <article class="blog-list-card">
                    <div class="blog-list-image">
                        <?php if (!empty($blog['image'])): ?>
                            <img src="../<?php echo htmlspecialchars($blog['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($blog['title'], ENT_QUOTES, 'UTF-8'); ?>">
                        <?php else: ?>
                            <span>No Image</span>
                        <?php endif; ?>
                    </div>
                    <div class="blog-list-content">
                        <div class="blog-list-meta">
                            <span><?php echo htmlspecialchars($blog['category_name'] ?? 'Uncategorized', ENT_QUOTES, 'UTF-8'); ?></span>
                            <span class="status-badge <?php echo $blog['status'] === 'published' ? 'published' : 'draft'; ?>">
                                <?php echo htmlspecialchars(ucfirst($blog['status']), ENT_QUOTES, 'UTF-8'); ?>
                            </span>
                        </div>
                        <h3><?php echo htmlspecialchars($blog['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
                        <p><?php echo htmlspecialchars($blog['short_description'] ?: $blog['slug'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <div class="blog-list-footer">
                            <small><?php echo $blog['published_at'] ? date('d M Y', strtotime($blog['published_at'])) : 'Not published'; ?></small>
                            <div class="table-actions">
                                <a href="add-blog.php?edit=<?php echo (int) $blog['id']; ?>" class="action-btn edit-btn"><i class="fa-solid fa-pen"></i></a>
                                <a href="list-blog.php?delete=<?php echo (int) $blog['id']; ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this blog?');"><i class="fa-solid fa-trash"></i></a>
                            </div>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
        <?php if ($totalPages > 1): ?>
            <nav class="pagination" aria-label="Blog pagination">
                <?php if ($currentPageNumber > 1): ?>
                    <a href="list-blog.php?page=<?php echo $currentPageNumber - 1; ?>"><i class="fa-solid fa-angle-left"></i> Prev</a>
                <?php endif; ?>

                <?php for ($page = 1; $page <= $totalPages; $page++): ?>
                    <a href="list-blog.php?page=<?php echo $page; ?>" class="<?php echo $page === $currentPageNumber ? 'active' : ''; ?>"><?php echo $page; ?></a>
                <?php endfor; ?>

                <?php if ($currentPageNumber < $totalPages): ?>
                    <a href="list-blog.php?page=<?php echo $currentPageNumber + 1; ?>">Next <i class="fa-solid fa-angle-right"></i></a>
                <?php endif; ?>
            </nav>
        <?php endif; ?>
    <?php else: ?>
        <div class="empty-table">No blogs found. <a href="add-blog.php">Add your first blog</a>.</div>
    <?php endif; ?>
</section>

<?php include __DIR__ . '/footer.php'; ?>
