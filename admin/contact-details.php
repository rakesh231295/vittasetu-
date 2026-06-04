<?php
$adminPageTitle = 'Contact Enquiries';
require __DIR__ . '/db.php';

$errors = [];
$success = '';
$perPage = 10;
$currentPageNumber = max(1, (int) ($_GET['page'] ?? 1));
$offset = ($currentPageNumber - 1) * $perPage;
$totalEnquiries = 0;
$totalPages = 1;

if (isset($_GET['delete'])) {
    $deleteId = (int) $_GET['delete'];

    if ($deleteId > 0) {
        try {
            $deleteStmt = $pdo->prepare('DELETE FROM enquiries WHERE id = ?');
            $deleteStmt->execute([$deleteId]);
            $success = 'Enquiry deleted successfully.';
        } catch (Throwable $e) {
            $errors[] = 'Unable to delete enquiry.';
        }
    }
}

try {
    $totalEnquiries = (int) $pdo->query('SELECT COUNT(*) FROM enquiries')->fetchColumn();
    $totalPages = max(1, (int) ceil($totalEnquiries / $perPage));

    if ($currentPageNumber > $totalPages) {
        $currentPageNumber = $totalPages;
        $offset = ($currentPageNumber - 1) * $perPage;
    }

    $stmt = $pdo->prepare('SELECT * FROM enquiries ORDER BY id DESC LIMIT :limit OFFSET :offset');
    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $enquiries = $stmt->fetchAll();
} catch (Throwable $e) {
    $enquiries = [];
    $errors[] = 'Unable to load enquiries. Please check enquiries table.';
}

include __DIR__ . '/header.php';
?>

<style>
    .contact-enquiry-card {
        width: 100% !important;
    }

    .contact-enquiry-table-wrap {
        width: 100% !important;
        overflow-x: auto;
    }

    .contact-enquiry-table {
        width: 100% !important;
        min-width: 100% !important;
        table-layout: fixed !important;
        border-collapse: separate;
        border-spacing: 0 10px;
    }

    .contact-enquiry-table th,
    .contact-enquiry-table td {
        padding: 18px 20px !important;
    }

    .contact-enquiry-table th:nth-child(1),
    .contact-enquiry-table td:nth-child(1) {
        width: 6% !important;
    }

    .contact-enquiry-table th:nth-child(2),
    .contact-enquiry-table td:nth-child(2) {
        width: 16% !important;
    }

    .contact-enquiry-table th:nth-child(3),
    .contact-enquiry-table td:nth-child(3) {
        width: 15% !important;
    }

    .contact-enquiry-table th:nth-child(4),
    .contact-enquiry-table td:nth-child(4) {
        width: 24% !important;
    }

    .contact-enquiry-table th:nth-child(5),
    .contact-enquiry-table td:nth-child(5) {
        width: 18% !important;
    }

    .contact-enquiry-table th:nth-child(6),
    .contact-enquiry-table td:nth-child(6) {
        width: 14% !important;
        white-space: normal !important;
        word-break: break-word;
    }

    .contact-enquiry-table th:nth-child(7),
    .contact-enquiry-table td:nth-child(7) {
        width: 7% !important;
    }
</style>

<section class="admin-table-card contact-enquiry-card">
    <div class="table-header">
        <div>
            <span class="admin-eyebrow">Contact Page</span>
            <h2>Contact Enquiries</h2>
            <p>View enquiries submitted from the public contact page.</p>
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

    <?php if ($enquiries): ?>
        <div class="table-responsive contact-enquiry-table-wrap">
            <table class="admin-table enquiry-table contact-enquiry-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Service</th>
                        <th>Message</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($enquiries as $index => $enquiry): ?>
                        <tr>
                            <td><?php echo $offset + $index + 1; ?></td>
                            <td><strong><?php echo htmlspecialchars($enquiry['full_name'], ENT_QUOTES, 'UTF-8'); ?></strong></td>
                            <td><?php echo htmlspecialchars($enquiry['mobile'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($enquiry['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($enquiry['service'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($enquiry['message'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <div class="table-actions">
                                    <a href="contact-details.php?delete=<?php echo (int) $enquiry['id']; ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this enquiry?');"><i class="fa-solid fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php if ($totalPages > 1): ?>
            <nav class="pagination" aria-label="Enquiry pagination">
                <?php if ($currentPageNumber > 1): ?>
                    <a href="contact-details.php?page=<?php echo $currentPageNumber - 1; ?>"><i class="fa-solid fa-angle-left"></i> Prev</a>
                <?php endif; ?>

                <?php for ($page = 1; $page <= $totalPages; $page++): ?>
                    <a href="contact-details.php?page=<?php echo $page; ?>" class="<?php echo $page === $currentPageNumber ? 'active' : ''; ?>"><?php echo $page; ?></a>
                <?php endfor; ?>

                <?php if ($currentPageNumber < $totalPages): ?>
                    <a href="contact-details.php?page=<?php echo $currentPageNumber + 1; ?>">Next <i class="fa-solid fa-angle-right"></i></a>
                <?php endif; ?>
            </nav>
        <?php endif; ?>
    <?php else: ?>
        <div class="empty-table">No enquiries found.</div>
    <?php endif; ?>
</section>

<?php include __DIR__ . '/footer.php'; ?>
