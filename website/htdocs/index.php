<?php
require __DIR__ . '/config.php';
$pdo = db_connect();

// fetch latest published articles
$stmt = $pdo->prepare("SELECT id, title, slug, excerpt, author, published_at FROM articles WHERE status = 'published' ORDER BY published_at DESC LIMIT 20");
$stmt->execute();
$articles = $stmt->fetchAll();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>My Newspaper</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header>
  <h1><a href="/">My Newspaper</a></h1>
  <nav><a href="/admin/login.php">Admin</a></nav>
</header>

<main>
  <?php if(empty($articles)): ?>
    <p>No articles published yet.</p>
  <?php else: ?>
    <ul class="article-list">
    <?php foreach($articles as $a): ?>
      <li class="article-card">
        <h2><a href="/article.php?slug=<?=htmlspecialchars($a['slug'])?>"><?=htmlspecialchars($a['title'])?></a></h2>
        <div class="post-meta">By <?=htmlspecialchars($a['author'])?> — <?=htmlspecialchars($a['published_at'])?></div>
        <?php if($a['excerpt']): ?><p><?=nl2br(htmlspecialchars($a['excerpt']))?></p><?php endif; ?>
      </li>
    <?php endforeach; ?>
    </ul>
  <?php endif; ?>
</main>
</body>
</html>
