<?php
require __DIR__ . '/db.php';

$errors = [];
$success = '';
$categories = [];
$editId = isset($_GET['edit']) ? (int) $_GET['edit'] : 0;
$isEdit = $editId > 0;
$adminPageTitle = $isEdit ? 'Edit Blog' : 'Add Blog';
$existingImage = '';

function createSlug($text)
{
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9]+/i', '-', $text);
    $text = trim($text, '-');
    return $text ?: 'blog-' . time();
}

try {
    $categoryStmt = $pdo->query('SELECT id, name FROM blog_categories WHERE status = 1 ORDER BY name ASC');
    $categories = $categoryStmt->fetchAll();
} catch (Throwable $e) {
    $errors[] = 'Unable to load categories. Please check blog_categories table.';
}

$formData = [
    'category_id' => '',
    'title' => '',
    'slug' => '',
    'short_description' => '',
    'description' => '',
    'meta_title' => '',
    'meta_description' => '',
    'status' => 'draft',
];

if ($isEdit) {
    try {
        $editStmt = $pdo->prepare('SELECT * FROM blogs WHERE id = ? LIMIT 1');
        $editStmt->execute([$editId]);
        $blog = $editStmt->fetch();

        if ($blog) {
            foreach ($formData as $key => $value) {
                $formData[$key] = (string) ($blog[$key] ?? $value);
            }

            $existingImage = $blog['image'] ?? '';
        } else {
            $errors[] = 'Blog not found.';
            $isEdit = false;
        }
    } catch (Throwable $e) {
        $errors[] = 'Unable to load blog data.';
        $isEdit = false;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($formData as $key => $value) {
        $formData[$key] = trim($_POST[$key] ?? $value);
    }

    if ($formData['title'] === '') {
        $errors[] = 'Blog title is required.';
    }

    if ($formData['description'] === '') {
        $errors[] = 'Blog description is required.';
    }

    $slug = $formData['slug'] !== '' ? createSlug($formData['slug']) : createSlug($formData['title']);
    $imagePath = $isEdit ? $existingImage : null;

    if (!empty($_FILES['image']['name'])) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        $fileType = $_FILES['image']['type'] ?? '';

        if (!in_array($fileType, $allowedTypes, true)) {
            $errors[] = 'Only JPG, PNG, WEBP, or GIF images are allowed.';
        } elseif (($_FILES['image']['size'] ?? 0) > 2 * 1024 * 1024) {
            $errors[] = 'Image size must be less than 2MB.';
        } else {
            $uploadDir = dirname(__DIR__) . '/uploads/blogs/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $fileName = $slug . '-' . time() . '.' . $extension;
            $targetPath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                if ($isEdit && $existingImage && str_starts_with($existingImage, 'uploads/blogs/')) {
                    $oldImagePath = dirname(__DIR__) . '/' . $existingImage;

                    if (is_file($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                $imagePath = 'uploads/blogs/' . $fileName;
            } else {
                $errors[] = 'Unable to upload blog image.';
            }
        }
    }

    if (!$errors) {
        try {
            $checkStmt = $pdo->prepare('SELECT id FROM blogs WHERE slug = ? AND id != ? LIMIT 1');
            $checkStmt->execute([$slug, $editId]);

            if ($checkStmt->fetch()) {
                $slug .= '-' . time();
            }

            $publishedAt = $formData['status'] === 'published' ? date('Y-m-d H:i:s') : null;
            $categoryId = $formData['category_id'] !== '' ? (int) $formData['category_id'] : null;

            if ($isEdit) {
                $stmt = $pdo->prepare(
                    'UPDATE blogs SET 
                    category_id = ?, title = ?, slug = ?, short_description = ?, description = ?, image = ?, 
                    meta_title = ?, meta_description = ?, status = ?, published_at = ?
                    WHERE id = ?'
                );

                $stmt->execute([
                    $categoryId,
                    $formData['title'],
                    $slug,
                    $formData['short_description'],
                    $formData['description'],
                    $imagePath,
                    $formData['meta_title'],
                    $formData['meta_description'],
                    $formData['status'],
                    $publishedAt,
                    $editId,
                ]);

                $success = 'Blog updated successfully.';
                $formData['slug'] = $slug;
                $existingImage = $imagePath ?? '';
            } else {
                $stmt = $pdo->prepare(
                    'INSERT INTO blogs 
                    (category_id, title, slug, short_description, description, image, meta_title, meta_description, status, published_at) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
                );

                $stmt->execute([
                    $categoryId,
                    $formData['title'],
                    $slug,
                    $formData['short_description'],
                    $formData['description'],
                    $imagePath,
                    $formData['meta_title'],
                    $formData['meta_description'],
                    $formData['status'],
                    $publishedAt,
                ]);

                $success = 'Blog added successfully.';
                $formData = array_map(fn() => '', $formData);
                $formData['status'] = 'draft';
            }
        } catch (Throwable $e) {
            $errors[] = $isEdit ? 'Unable to update blog.' : 'Unable to save blog. Please check blogs table.';
        }
    }
}

include __DIR__ . '/header.php';
?>

<section class="admin-form-card">
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

    <form method="post" enctype="multipart/form-data" class="admin-form">
        <div class="form-row">
            <div class="form-group">
                <label for="title">Blog Title</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($formData['title'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Enter blog title" required>
            </div>

            <div class="form-group">
                <label for="slug">Slug</label>
                <input type="text" id="slug" name="slug" value="<?php echo htmlspecialchars($formData['slug'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="auto-generated-if-empty">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="category_id">Category</label>
                <select id="category_id" name="category_id">
                    <option value="">Select Category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo (int) $category['id']; ?>" <?php echo (string) $formData['category_id'] === (string) $category['id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status">
                    <option value="draft" <?php echo $formData['status'] === 'draft' ? 'selected' : ''; ?>>Draft</option>
                    <option value="published" <?php echo $formData['status'] === 'published' ? 'selected' : ''; ?>>Published</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="short_description">Short Description</label>
            <textarea id="short_description" name="short_description" rows="3" placeholder="Short summary for blog card"><?php echo htmlspecialchars($formData['short_description'], ENT_QUOTES, 'UTF-8'); ?></textarea>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="9" placeholder="Write full blog content" required><?php echo htmlspecialchars($formData['description'], ENT_QUOTES, 'UTF-8'); ?></textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="image">Blog Image</label>
                <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp,image/gif">
                <?php if ($existingImage): ?>
                    <div class="current-image">
                        <img src="../<?php echo htmlspecialchars($existingImage, ENT_QUOTES, 'UTF-8'); ?>" alt="Current blog image">
                        <span>Current Image</span>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="meta_title">Meta Title</label>
                <input type="text" id="meta_title" name="meta_title" value="<?php echo htmlspecialchars($formData['meta_title'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="SEO title">
            </div>
        </div>

        <div class="form-group">
            <label for="meta_description">Meta Description</label>
            <textarea id="meta_description" name="meta_description" rows="3" placeholder="SEO description"><?php echo htmlspecialchars($formData['meta_description'], ENT_QUOTES, 'UTF-8'); ?></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="admin-submit-btn"><i class="fa-solid fa-floppy-disk"></i> <?php echo $isEdit ? 'Update Blog' : 'Save Blog'; ?></button>
            <a href="list-blog.php" class="admin-cancel-btn">Cancel</a>
        </div>
    </form>
</section>

<?php include __DIR__ . '/footer.php'; ?>
