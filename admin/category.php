<?php
$adminPageTitle = 'Categories';
require __DIR__ . '/db.php';

$success = '';
$errors = [];
$perPage = 6;
$currentPageNumber = max(1, (int) ($_GET['page'] ?? 1));
$offset = ($currentPageNumber - 1) * $perPage;
$totalCategories = 0;
$totalPages = 1;

if (isset($_GET['delete'])) {
    $deleteId = (int) $_GET['delete'];

    if ($deleteId > 0) {
        try {
            $blogCheck = $pdo->prepare('SELECT COUNT(*) FROM blogs WHERE category_id = ?');
            $blogCheck->execute([$deleteId]);
            $blogCount = (int) $blogCheck->fetchColumn();

            if ($blogCount > 0) {
                $errors[] = 'This category has blogs. Please move or delete blogs first.';
            } else {
                $deleteStmt = $pdo->prepare('DELETE FROM blog_categories WHERE id = ?');
                $deleteStmt->execute([$deleteId]);
                $success = 'Category deleted successfully.';
            }
        } catch (Throwable $e) {
            $errors[] = 'Unable to delete category.';
        }
    }
}

try {
    $totalCategories = (int) $pdo->query('SELECT COUNT(*) FROM blog_categories')->fetchColumn();
    $totalPages = max(1, (int) ceil($totalCategories / $perPage));

    if ($currentPageNumber > $totalPages) {
        $currentPageNumber = $totalPages;
        $offset = ($currentPageNumber - 1) * $perPage;
    }

    $stmt = $pdo->prepare(
        'SELECT blog_categories.*, COUNT(blogs.id) AS total_blogs
        FROM blog_categories
        LEFT JOIN blogs ON blogs.category_id = blog_categories.id
        GROUP BY blog_categories.id
        ORDER BY blog_categories.id DESC
        LIMIT :limit OFFSET :offset'
    );
    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $categories = $stmt->fetchAll();
} catch (Throwable $e) {
    $categories = [];
    $errors[] = 'Unable to load categories. Please check blog_categories table.';
}

include __DIR__ . '/header.php';
?>

<section class="admin-table-card">
    <div class="table-header">
        <div>
            <span class="admin-eyebrow">Blog Categories</span>
            <h2>Manage Categories</h2>
            <p>Create, organize, and manage blog categories.</p>
        </div>
        <a href="create-category.php" class="admin-submit-btn"><i class="fa-solid fa-folder-plus"></i> Add Category</a>
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

    <?php if ($categories): ?>
        <div class="table-responsive category-table-responsive">
            <table class="admin-table category-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Category</th>
                        <th>Slug</th>
                        <th>Blogs</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $index => $category): ?>
                        <tr>
                            <td><?php echo $offset + $index + 1; ?></td>
                            <td>
                                <div class="table-title-cell">
                                    <span class="category-mini-icon"><i class="fa-solid fa-layer-group"></i></span>
                                    <strong><?php echo htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8'); ?></strong>
                                </div>
                            </td>
                            <td><?php echo htmlspecialchars($category['slug'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo (int) $category['total_blogs']; ?></td>
                            <td>
                                <span class="status-badge <?php echo (int) $category['status'] === 1 ? 'published' : 'draft'; ?>">
                                    <?php echo (int) $category['status'] === 1 ? 'Active' : 'Inactive'; ?>
                                </span>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="create-category.php?edit=<?php echo (int) $category['id']; ?>" class="action-btn edit-btn"><i class="fa-solid fa-pen"></i></a>
                                    <a href="category.php?delete=<?php echo (int) $category['id']; ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this category?');"><i class="fa-solid fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php if ($totalPages > 1): ?>
            <nav class="pagination" aria-label="Category pagination">
                <?php if ($currentPageNumber > 1): ?>
                    <a href="category.php?page=<?php echo $currentPageNumber - 1; ?>"><i class="fa-solid fa-angle-left"></i> Prev</a>
                <?php endif; ?>

                <?php for ($page = 1; $page <= $totalPages; $page++): ?>
                    <a href="category.php?page=<?php echo $page; ?>" class="<?php echo $page === $currentPageNumber ? 'active' : ''; ?>"><?php echo $page; ?></a>
                <?php endfor; ?>

                <?php if ($currentPageNumber < $totalPages): ?>
                    <a href="category.php?page=<?php echo $currentPageNumber + 1; ?>">Next <i class="fa-solid fa-angle-right"></i></a>
                <?php endif; ?>
            </nav>
        <?php endif; ?>
    <?php else: ?>
        <div class="empty-table">No categories found. <a href="create-category.php">Add your first category</a>.</div>
    <?php endif; ?>
</section>

<?php include __DIR__ . '/footer.php'; ?>
