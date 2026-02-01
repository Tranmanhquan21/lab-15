<?php
/**
 * LAB 14: Topic 1 Pagination, Topic 2 Upload, Topic 3 Flash + PRG
 * LAB 15: Topic 3 Ghi log lỗi DB, upload, exception
 */
require_once __DIR__ . '/helpers.php';

class ProductController
{
    private Product $model;
    private array $config;
    private int $perPage = 5;

    public function __construct(Product $model, array $config)
    {
        $this->model = $model;
        $this->config = $config;
    }

    /** Lab 14 Topic 1: Danh sách phân trang, giữ ?page= khi thao tác */
    public function index(): void
    {
        $page = max(1, (int)($_GET['page'] ?? 1));
        $total = $this->model->countAll();
        $totalPages = $total > 0 ? (int) ceil($total / $this->perPage) : 1;
        if ($page > $totalPages) {
            $page = $totalPages;
        }
        $offset = ($page - 1) * $this->perPage;
        $items = $this->model->getPage($this->perPage, $offset);
        $baseUrl = $this->baseUrl();
        require __DIR__ . '/views/list.php';
    }

    public function show(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $item = $id ? $this->model->find($id) : null;
        if (!$item) {
            set_flash('error', 'Không tìm thấy sản phẩm.');
            $this->redirect('?action=index');
            return;
        }
        $baseUrl = $this->baseUrl();
        require __DIR__ . '/views/show.php';
    }

    public function createForm(): void
    {
        $baseUrl = $this->baseUrl();
        require __DIR__ . '/views/create.php';
    }

    /** Lab 14 Topic 3: PRG – POST xong redirect + flash */
    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('?action=index');
            return;
        }
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        if ($name === '') {
            set_flash('error', 'Tên sản phẩm không được để trống.');
            $this->redirect('?action=create');
            return;
        }
        $imagePath = $this->handleUpload('image');
        if ($imagePath === false) {
            set_flash('error', 'Ảnh không hợp lệ (jpg/png/webp, tối đa 2MB).');
            $this->redirect('?action=create');
            return;
        }
        try {
            $this->model->create($name, $description, $imagePath);
            set_flash('success', 'Đã thêm sản phẩm.');
        } catch (Exception $e) {
            write_log('Store product: ' . $e->getMessage(), 'ERROR');
            set_flash('error', 'Lỗi khi lưu.');
        }
        $this->redirect('?action=index');
    }

    public function editForm(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $item = $id ? $this->model->find($id) : null;
        if (!$item) {
            set_flash('error', 'Không tìm thấy sản phẩm.');
            $this->redirect('?action=index');
            return;
        }
        $baseUrl = $this->baseUrl();
        require __DIR__ . '/views/edit.php';
    }

    /** Lab 14 Topic 2: Thay ảnh mới thì xóa ảnh cũ. Topic 3: PRG */
    public function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('?action=index');
            return;
        }
        $id = (int)($_POST['id'] ?? 0);
        $item = $id ? $this->model->find($id) : null;
        if (!$item) {
            set_flash('error', 'Không tìm thấy sản phẩm.');
            $this->redirect('?action=index');
            return;
        }
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        if ($name === '') {
            set_flash('error', 'Tên sản phẩm không được để trống.');
            $this->redirect('?action=edit&id=' . $id);
            return;
        }
        $newImagePath = $this->handleUpload('image');
        if ($newImagePath === false && !empty($_FILES['image']['name'])) {
            set_flash('error', 'Ảnh không hợp lệ (định dạng hoặc dung lượng).');
            $this->redirect('?action=edit&id=' . $id);
            return;
        }
        $imagePath = $newImagePath !== null ? $newImagePath : $item['image_path'];
        if ($newImagePath !== null && !empty($item['image_path'])) {
            $oldPath = $this->uploadPath($item['image_path']);
            if (is_file($oldPath)) {
                @unlink($oldPath);
            }
        }
        try {
            $this->model->update($id, $name, $description, $imagePath);
            set_flash('success', 'Đã cập nhật sản phẩm.');
        } catch (Exception $e) {
            write_log('Update product: ' . $e->getMessage(), 'ERROR');
            set_flash('error', 'Lỗi khi cập nhật.');
        }
        $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
        $this->redirect('?action=index&page=' . $page);
    }

    /** Lab 14 Topic 3: PRG */
    public function delete(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('?action=index');
            return;
        }
        $id = (int)($_POST['id'] ?? 0);
        $item = $id ? $this->model->find($id) : null;
        $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
        if (!$item) {
            set_flash('error', 'Không tìm thấy sản phẩm.');
            $this->redirect('?action=index&page=' . $page);
            return;
        }
        if (!empty($item['image_path'])) {
            $path = $this->uploadPath($item['image_path']);
            if (is_file($path)) {
                @unlink($path);
            }
        }
        try {
            $this->model->delete($id);
            set_flash('success', 'Đã xóa sản phẩm.');
        } catch (Exception $e) {
            write_log('Delete product: ' . $e->getMessage(), 'ERROR');
            set_flash('error', 'Lỗi khi xóa.');
        }
        $this->redirect('?action=index&page=' . $page);
    }

    /**
     * Lab 14 Topic 2: Upload – whitelist jpg/jpeg/png/webp, max 2MB, uniqid().ext
     * Lab 15 Topic 3: Ghi log khi lỗi upload
     */
    private function handleUpload(string $field): ?string
    {
        if (empty($_FILES[$field]['name']) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
            return null;
        }
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $ext = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed, true)) {
            write_log('Upload rejected: invalid extension ' . $ext, 'WARNING');
            return false;
        }
        $maxBytes = ($this->config['upload_max_mb'] ?? 2) * 1024 * 1024;
        if ($_FILES[$field]['size'] > $maxBytes) {
            write_log('Upload rejected: file too large', 'WARNING');
            return false;
        }
        $uploadDir = dirname(__DIR__) . '/public/uploads';
        if (!is_dir($uploadDir)) {
            @mkdir($uploadDir, 0755, true);
        }
        $newName = uniqid('', true) . '.' . $ext;
        $dest = $uploadDir . '/' . $newName;
        if (!move_uploaded_file($_FILES[$field]['tmp_name'], $dest)) {
            write_log('Upload move_uploaded_file failed', 'ERROR');
            return false;
        }
        return 'uploads/' . $newName;
    }

    private function uploadPath(string $relativePath): string
    {
        return dirname(__DIR__) . '/public/' . ltrim($relativePath, '/');
    }

    private function baseUrl(): string
    {
        $script = $_SERVER['SCRIPT_NAME'] ?? '';
        return rtrim(dirname($script), '/');
    }

    private function redirect(string $url): void
    {
        $base = $this->baseUrl();
        header('Location: ' . $base . '/' . ltrim($url, '/'));
        exit;
    }
}
