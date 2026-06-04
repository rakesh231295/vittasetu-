<?php
$adminPageTitle = 'Lead Form';
require __DIR__ . '/db.php';

$errors = [];
$success = '';
$perPage = 10;
$currentPageNumber = max(1, (int) ($_GET['page'] ?? 1));
$offset = ($currentPageNumber - 1) * $perPage;
$totalLeads = 0;
$totalPages = 1;

if (isset($_GET['delete'])) {
    $deleteId = (int) $_GET['delete'];

    if ($deleteId > 0) {
        try {
            $deleteStmt = $pdo->prepare('DELETE FROM leads WHERE id = ?');
            $deleteStmt->execute([$deleteId]);
            $success = 'Lead deleted successfully.';
        } catch (Throwable $e) {
            $errors[] = 'Unable to delete lead.';
        }
    }
}

try {
    $totalLeads = (int) $pdo->query('SELECT COUNT(*) FROM leads')->fetchColumn();
    $totalPages = max(1, (int) ceil($totalLeads / $perPage));

    if ($currentPageNumber > $totalPages) {
        $currentPageNumber = $totalPages;
        $offset = ($currentPageNumber - 1) * $perPage;
    }

    $stmt = $pdo->prepare('SELECT * FROM leads ORDER BY id DESC LIMIT :limit OFFSET :offset');
    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $leads = $stmt->fetchAll();
} catch (Throwable $e) {
    $leads = [];
    $errors[] = 'Unable to load leads. Please check leads table.';
}

include __DIR__ . '/header.php';
?>

<section class="admin-table-card contact-enquiry-card">
    <div class="table-header">
        <div>
            <span class="admin-eyebrow">Home Page</span>
            <h2>Lead Form Submissions</h2>
            <p>View leads submitted from the home page quick apply form.</p>
        </div>
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

    <?php if ($leads): ?>
        <div class="table-responsive contact-enquiry-table-wrap">
            <table class="admin-table enquiry-table contact-enquiry-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Requirement</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($leads as $index => $lead): ?>
                        <tr>
                            <td><?php echo $offset + $index + 1; ?></td>
                            <td><strong><?php echo htmlspecialchars($lead['full_name'], ENT_QUOTES, 'UTF-8'); ?></strong></td>
                            <td><?php echo htmlspecialchars($lead['mobile'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($lead['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($lead['service'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($lead['message'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <span class="status-badge published"><?php echo htmlspecialchars(ucfirst($lead['status'] ?? 'new'), ENT_QUOTES, 'UTF-8'); ?></span>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="lead.php?delete=<?php echo (int) $lead['id']; ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this lead?');"><i class="fa-solid fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php if ($totalPages > 1): ?>
            <nav class="pagination" aria-label="Lead pagination">
                <?php if ($currentPageNumber > 1): ?>
                    <a href="lead.php?page=<?php echo $currentPageNumber - 1; ?>"><i class="fa-solid fa-angle-left"></i> Prev</a>
                <?php endif; ?>

                <?php for ($page = 1; $page <= $totalPages; $page++): ?>
                    <a href="lead.php?page=<?php echo $page; ?>" class="<?php echo $page === $currentPageNumber ? 'active' : ''; ?>"><?php echo $page; ?></a>
                <?php endfor; ?>

                <?php if ($currentPageNumber < $totalPages): ?>
                    <a href="lead.php?page=<?php echo $currentPageNumber + 1; ?>">Next <i class="fa-solid fa-angle-right"></i></a>
                <?php endif; ?>
            </nav>
        <?php endif; ?>
    <?php else: ?>
        <div class="empty-table">No leads found.</div>
    <?php endif; ?>
</section>

<?php include __DIR__ . '/footer.php'; ?>
