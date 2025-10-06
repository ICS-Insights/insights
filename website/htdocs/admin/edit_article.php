<?php
require __DIR__ . '/../config.php';
if (!is_logged_in()) { header("Location: login.php"); exit; }
$pdo = db_connect();

$id = $_GET['id'] ?? null;
if (!$id) { header("Location: dashboard.php"); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $slug = preg_replace('/[^a-z0-9\-]+/','-',strtolower(trim($_POST['slug'] ?? $title)));
    $author = $_POST['author'] ?? '';
    $content = $_POST['content'] ?? '';
    $excerpt = $_POST['excerpt'] ?? null;
    $category = $_POST['category'] ?? null;
    $status = $_POST['status'] ?? 'draft';
    $published_at = ($status === 'published') ? date('Y-m-d H:i:s') : null;

    $stmt = $pdo->prepare("UPDATE articles SET title=?, slug=?, author=?, content=?, excerpt=?, category=?, status=?, published_at=? WHERE id=?");
    $stmt->execute([$title,$slug,$author,$content,$excerpt,$category,$status,$published_at,$id]);

    header("Location: dashboard.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM articles WHERE id = ? LIMIT 1");
$stmt->execute([$id]);
$article = $stmt->fetch();
if (!$article) { echo "Not found"; exit; }
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Edit Article</title></head>
<body>
<h2>Edit Article</h2>
<form method="post">
  <div class="form-field"><label>Title <input name="title" value="<?=htmlspecialchars($article['title'])?>"></label></div>
  <div class="form-field"><label>Slug <input name="slug" value="<?=htmlspecialchars($article['slug'])?>"></label></div>
  <div class="form-field"><label>Author <input name="author" value="<?=htmlspecialchars($article['author'])?>"></label></div>
  <div class="form-field"><label>Category <input name="category" value="<?=htmlspecialchars($article['category'])?>"></label></div>
  <div class="form-field"><label>Excerpt <textarea name="excerpt"><?=htmlspecialchars($article['excerpt'])?></textarea></label></div>
  <div class="form-field"><label>Content <textarea name="content"><?=htmlspecialchars($article['content'])?></textarea></label></div>
  <div class="form-field">
    <label>Status
      <select name="status">
        <option value="draft" <?= $article['status'] === 'draft' ? 'selected' : '' ?>>Draft</option>
        <option value="published" <?= $article['status'] === 'published' ? 'selected' : '' ?>>Published</option>
      </select>
    </label>
  </div>
  <div><button>Save</button></div>
</form>
</body>
</html>
