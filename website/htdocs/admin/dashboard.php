<?php
require __DIR__ . '/../config.php';
if (!is_logged_in()) { header("Location: login.php"); exit; }
$pdo = db_connect();

// show latest articles (including drafts)
$stmt = $pdo->query("SELECT id, title, status, published_at FROM articles ORDER BY created_at DESC LIMIT 50");
$articles = $stmt->fetchAll();
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Dashboard</title></head>
<body>
<h2>Dashboard</h2>
<p>Welcome, <?=htmlspecialchars($_SESSION['display_name'] ?? '');?> | <a href="logout.php">Logout</a></p>
<p><a href="new_article.php">Create new article</a></p>

<table border="1" cellpadding="6">
  <tr><th>ID</th><th>Title</th><th>Status</th><th>Published At</th><th>Actions</th></tr>
  <?php foreach($articles as $a): ?>
    <tr>
      <td><?= $a['id'] ?></td>
      <td><?= htmlspecialchars($a['title']) ?></td>
      <td><?= $a['status'] ?></td>
      <td><?= $a['published_at'] ?></td>
      <td>
        <a href="edit_article.php?id=<?= $a['id'] ?>">Edit</a>
        <!-- implement delete_article.php if you want -->
      </td>
    </tr>
  <?php endforeach; ?>
</table>
</body>
</html>
