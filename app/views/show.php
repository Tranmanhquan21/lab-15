<?php $pageTitle = 'Chi tiết sản phẩm'; ?>
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

        <h1 class="mb-4">Chi tiết sản phẩm</h1>
        <dl class="row">
            <dt class="col-sm-2">ID</dt>
            <dd class="col-sm-10"><?= (int)$item['id'] ?></dd>
            <dt class="col-sm-2">Tên</dt>
            <dd class="col-sm-10"><?= htmlspecialchars($item['name']) ?></dd>
            <dt class="col-sm-2">Mô tả</dt>
            <dd class="col-sm-10"><?= nl2br(htmlspecialchars($item['description'] ?? '')) ?></dd>
            <dt class="col-sm-2">Ảnh</dt>
            <dd class="col-sm-10">
                <?php if (!empty($item['image_path'])): ?>
                    <img src="<?= htmlspecialchars($baseUrl) ?>/<?= htmlspecialchars($item['image_path']) ?>" alt="" class="img-fluid" style="max-width:400px;">
                <?php else: ?>
                    <span class="text-muted">Không có ảnh</span>
                <?php endif; ?>
            </dd>
        </dl>
        <p>
            <a href="<?= htmlspecialchars($baseUrl) ?>/index.php?action=index" class="btn btn-secondary">← Danh sách</a>
            <a href="<?= htmlspecialchars($baseUrl) ?>/index.php?action=edit&id=<?= (int)$item['id'] ?>" class="btn btn-primary">Sửa</a>
        </p>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
