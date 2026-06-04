<?php
$adminPageTitle = 'Dashboard';
include __DIR__ . '/header.php';
?>

<section class="dashboard-grid">
    <div class="dashboard-card">
        <span class="dashboard-card-icon"><i class="fa-solid fa-newspaper"></i></span>
        <div>
            <h2>Manage Blogs</h2>
            <p>Create, edit, publish, and manage blog posts from one place.</p>
            <a href="list-blog.php">View Blogs</a>
        </div>
    </div>

    <div class="dashboard-card">
        <span class="dashboard-card-icon"><i class="fa-solid fa-layer-group"></i></span>
        <div>
            <h2>Categories</h2>
            <p>Organize blog posts using categories for better content structure.</p>
            <a href="category.php">View Categories</a>
        </div>
    </div>

    <div class="dashboard-card">
        <span class="dashboard-card-icon"><i class="fa-solid fa-pen-to-square"></i></span>
        <div>
            <h2>Add New Blog</h2>
            <p>Write a new article and publish it on the website blog section.</p>
            <a href="add-blog.php">Add Blog</a>
        </div>
    </div>
</section>

<?php include __DIR__ . '/footer.php'; ?>
