<?php
require __DIR__ . '/config.php';
$pdo = db_connect();

$slug = $_GET['slug'] ?? null;
if (!$slug) {
    header("Location: /");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM articles WHERE slug = ? AND status = 'published' LIMIT 1");
$stmt->execute([$slug]);
$article = $stmt->fetch();
if (!$article) {
    http_response_code(404);
    echo "Article not found.";
    exit;
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title><?=htmlspecialchars($article['title'])?> - My Newspaper</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header>
  <h1><a href="/">My Newspaper</a></h1>
  <nav><a href="/admin/login.php">Admin</a></nav>
</header>

<main>
  <article>
    <h2><?=htmlspecialchars($article['title'])?></h2>
    <div class="post-meta">By <?=htmlspecialchars($article['author'])?> — <?=htmlspecialchars($article['published_at'])?></div>
    <?php if($article['thumbnail']): ?>
      <img src="<?=htmlspecialchars($article['thumbnail'])?>" alt="" style="max-width:100%;height:auto;">
    <?php endif; ?>
    <div class="article-body"><?=nl2br(htmlspecialchars($article['content']))?></div>
  </article>
</main>
</body>
</html>
