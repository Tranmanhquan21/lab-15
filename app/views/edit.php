<?php $pageTitle = 'Sửa sản phẩm'; ?>
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
        <?php if ($errorMsg = get_flash('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show"><?= htmlspecialchars($errorMsg) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <h1 class="mb-4">Sửa sản phẩm</h1>
        <form method="post" action="<?= htmlspecialchars($baseUrl) ?>/index.php?action=update" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= (int)$item['id'] ?>">
            <input type="hidden" name="page" value="<?= (int)($_GET['page'] ?? 1) ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="name" name="name" required value="<?= htmlspecialchars($item['name']) ?>">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?= htmlspecialchars($item['description'] ?? '') ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Ảnh hiện tại</label>
                <?php if (!empty($item['image_path'])): ?>
                    <div><img src="<?= htmlspecialchars($baseUrl) ?>/<?= htmlspecialchars($item['image_path']) ?>" alt="" class="img-thumbnail" style="max-width:120px;"></div>
                <?php else: ?>
                    <span class="text-muted">Không có ảnh</span>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Thay ảnh mới (jpg, png, webp; tối đa 2MB)</label>
                <input type="file" class="form-control" id="image" name="image" accept=".jpg,.jpeg,.png,.webp">
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="<?= htmlspecialchars($baseUrl) ?>/index.php?action=index&page=<?= (int)($_GET['page'] ?? 1) ?>" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
