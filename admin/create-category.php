<?php
require __DIR__ . '/db.php';

$errors = [];
$success = '';
$editId = isset($_GET['edit']) ? (int) $_GET['edit'] : 0;
$isEdit = $editId > 0;
$adminPageTitle = $isEdit ? 'Edit Category' : 'Add Category';
$hasDescriptionColumn = false;
$formData = [
    'name' => '',
    'slug' => '',
    'description' => '',
    'status' => '1',
];

try {
    $columnStmt = $pdo->query("SHOW COLUMNS FROM blog_categories LIKE 'description'");
    $hasDescriptionColumn = (bool) $columnStmt->fetch();
} catch (Throwable $e) {
    $hasDescriptionColumn = false;
}

function createCategorySlug($text)
{
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9]+/i', '-', $text);
    $text = trim($text, '-');
    return $text ?: 'category-' . time();
}

if ($isEdit) {
    try {
        $editStmt = $pdo->prepare('SELECT * FROM blog_categories WHERE id = ? LIMIT 1');
        $editStmt->execute([$editId]);
        $category = $editStmt->fetch();

        if ($category) {
            foreach ($formData as $key => $value) {
                $formData[$key] = (string) ($category[$key] ?? $value);
            }
        } else {
            $errors[] = 'Category not found.';
            $isEdit = false;
        }
    } catch (Throwable $e) {
        $errors[] = 'Unable to load category data.';
        $isEdit = false;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($formData as $key => $value) {
        $formData[$key] = trim($_POST[$key] ?? $value);
    }

    if ($formData['name'] === '') {
        $errors[] = 'Category name is required.';
    }

    $slug = $formData['slug'] !== '' ? createCategorySlug($formData['slug']) : createCategorySlug($formData['name']);

    if (!$errors) {
        try {
            $checkStmt = $pdo->prepare('SELECT id FROM blog_categories WHERE slug = ? AND id != ? LIMIT 1');
            $checkStmt->execute([$slug, $editId]);

            if ($checkStmt->fetch()) {
                $errors[] = 'Category slug already exists.';
            } else {
                if ($isEdit) {
                    if ($hasDescriptionColumn) {
                        $stmt = $pdo->prepare(
                            'UPDATE blog_categories SET name = ?, slug = ?, description = ?, status = ? WHERE id = ?'
                        );

                        $stmt->execute([
                            $formData['name'],
                            $slug,
                            $formData['description'],
                            (int) $formData['status'],
                            $editId,
                        ]);
                    } else {
                        $stmt = $pdo->prepare(
                            'UPDATE blog_categories SET name = ?, slug = ?, status = ? WHERE id = ?'
                        );

                        $stmt->execute([
                            $formData['name'],
                            $slug,
                            (int) $formData['status'],
                            $editId,
                        ]);
                    }

                    $success = 'Category updated successfully.';
                    $formData['slug'] = $slug;
                } else {
                    if ($hasDescriptionColumn) {
                        $stmt = $pdo->prepare(
                            'INSERT INTO blog_categories (name, slug, description, status) VALUES (?, ?, ?, ?)'
                        );

                        $stmt->execute([
                            $formData['name'],
                            $slug,
                            $formData['description'],
                            (int) $formData['status'],
                        ]);
                    } else {
                        $stmt = $pdo->prepare(
                            'INSERT INTO blog_categories (name, slug, status) VALUES (?, ?, ?)'
                        );

                        $stmt->execute([
                            $formData['name'],
                            $slug,
                            (int) $formData['status'],
                        ]);
                    }

                    $success = 'Category added successfully.';
                    $formData = [
                        'name' => '',
                        'slug' => '',
                        'description' => '',
                        'status' => '1',
                    ];
                }
            }
        } catch (Throwable $e) {
            $errors[] = $isEdit ? 'Unable to update category.' : 'Unable to save category. Please check blog_categories table.';
        }
    }
}

include __DIR__ . '/header.php';
?>

<section class="admin-form-card category-form-card">
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
        <div class="form-row">
            <div class="form-group">
                <label for="name">Category Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($formData['name'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Enter category name" required>
            </div>

            <div class="form-group">
                <label for="slug">Slug</label>
                <input type="text" id="slug" name="slug" value="<?php echo htmlspecialchars($formData['slug'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="auto-generated-if-empty">
            </div>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="5" placeholder="Write category description"><?php echo htmlspecialchars($formData['description'], ENT_QUOTES, 'UTF-8'); ?></textarea>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select id="status" name="status">
                <option value="1" <?php echo $formData['status'] === '1' ? 'selected' : ''; ?>>Active</option>
                <option value="0" <?php echo $formData['status'] === '0' ? 'selected' : ''; ?>>Inactive</option>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" class="admin-submit-btn"><i class="fa-solid fa-folder-plus"></i> <?php echo $isEdit ? 'Update Category' : 'Save Category'; ?></button>
            <a href="category.php" class="admin-cancel-btn">View Categories</a>
        </div>
    </form>
</section>

<?php include __DIR__ . '/footer.php'; ?>
