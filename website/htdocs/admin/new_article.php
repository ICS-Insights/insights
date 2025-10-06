<?php
require __DIR__ . '/../config.php';
if (!is_logged_in()) { header("Location: login.php"); exit; }
$pdo = db_connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $slug = preg_replace('/[^a-z0-9\-]+/','-',strtolower(trim($_POST['slug'] ?? $title)));
    $author = $_POST['author'] ?? ($_SESSION['display_name'] ?? 'Unknown');
    $content = $_POST['content'] ?? '';
    $excerpt = $_POST['excerpt'] ?? null;
    $category = $_POST['category'] ?? null;
    $status = $_POST['status'] ?? 'draft';
    $published_at = ($status === 'published') ? date('Y-m-d H:i:s') : null;

    $stmt = $pdo->prepare("INSERT INTO articles (title, slug, author, content, excerpt, category, status, published_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$title, $slug, $author, $content, $excerpt, $category, $status, $published_at]);

    header("Location: dashboard.php");
    exit;
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>New Article</title></head>
<body>
<h2>Create Article</h2>
<form method="post">
  <div class="form-field"><label>Title <input name="title" required></label></div>
  <div class="form-field"><label>Slug <input name="slug" placeholder="optional - auto-generated"></label></div>
  <div class="form-field"><label>Author <input name="author"></label></div>
  <div class="form-field"><label>Category <input name="category"></label></div>
  <div class="form-field"><label>Excerpt <textarea name="excerpt"></textarea></label></div>
  <div class="form-field"><label>Content <textarea name="content" required></textarea></label></div>
  <div class="form-field">
    <label>Status
      <select name="status">
        <option value="draft">Draft</option>
        <option value="published">Published</option>
      </select>
    </label>
  </div>
  <div><button>Save</button></div>
</form>
</body>
</html>
