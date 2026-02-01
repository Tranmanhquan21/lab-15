<?php $pageTitle = 'Danh sách sản phẩm'; $currentPage = $page; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-4">
        <?php if ($successMsg = get_flash('success')): ?>
            <div class="alert alert-success alert-dismissible fade show"><?= htmlspecialchars($successMsg) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if ($errorMsg = get_flash('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show"><?= htmlspecialchars($errorMsg) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <h1 class="mb-4">Danh sách sản phẩm</h1>
        <p class="text-muted">Trang <?= $currentPage ?>/<?= $totalPages ?> – Tổng <?= $total ?> bản ghi</p>
        <p><a href="<?= htmlspecialchars($baseUrl) ?>/index.php?action=create" class="btn btn-primary">Thêm sản phẩm</a></p>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Ảnh</th>
                        <th>Tên</th>
                        <th>Mô tả</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $row): ?>
                    <tr>
                        <td><?= (int)$row['id'] ?></td>
                        <td>
                            <?php if (!empty($row['image_path'])): ?>
                                <img src="<?= htmlspecialchars($baseUrl) ?>/<?= htmlspecialchars($row['image_path']) ?>" alt="" class="img-thumbnail" style="max-width:80px;max-height:80px;object-fit:cover;">
                            <?php else: ?>
                                <span class="text-muted">—</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars(mb_substr($row['description'] ?? '', 0, 50)) ?>...</td>
                        <td>
                            <a href="<?= htmlspecialchars($baseUrl) ?>/index.php?action=show&id=<?= (int)$row['id'] ?>&page=<?= $currentPage ?>" class="btn btn-sm btn-outline-secondary">Xem</a>
                            <a href="<?= htmlspecialchars($baseUrl) ?>/index.php?action=edit&id=<?= (int)$row['id'] ?>&page=<?= $currentPage ?>" class="btn btn-sm btn-outline-primary">Sửa</a>
                            <form method="post" action="<?= htmlspecialchars($baseUrl) ?>/index.php?action=delete" class="d-inline" onsubmit="return confirm('Xóa sản phẩm này?');">
                                <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                                <input type="hidden" name="page" value="<?= $currentPage ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger">Xóa</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php if ($totalPages > 1): ?>
        <nav aria-label="Phân trang" class="mt-3">
            <ul class="pagination justify-content-center">
                <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="<?= htmlspecialchars($baseUrl) ?>/index.php?action=index&page=1">First</a>
                </li>
                <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="<?= htmlspecialchars($baseUrl) ?>/index.php?action=index&page=<?= $currentPage - 1 ?>">Prev</a>
                </li>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= $i === $currentPage ? 'active' : '' ?>">
                    <a class="page-link" href="<?= htmlspecialchars($baseUrl) ?>/index.php?action=index&page=<?= $i ?>"><?= $i ?></a>
                </li>
                <?php endfor; ?>
                <li class="page-item <?= $currentPage >= $totalPages ? 'disabled' : '' ?>">
                    <a class="page-link" href="<?= htmlspecialchars($baseUrl) ?>/index.php?action=index&page=<?= $currentPage + 1 ?>">Next</a>
                </li>
                <li class="page-item <?= $currentPage >= $totalPages ? 'disabled' : '' ?>">
                    <a class="page-link" href="<?= htmlspecialchars($baseUrl) ?>/index.php?action=index&page=<?= $totalPages ?>">Last</a>
                </li>
            </ul>
        </nav>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
