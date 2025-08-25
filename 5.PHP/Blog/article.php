<?php
/**
 * Страница статьи с MySQL
 */

require_once 'database/db_functions.php';

// Получаем ID статьи
$articleId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($articleId <= 0) {
    header("Location: index.php");
    exit;
}

// Получаем статью из БД
$article = getArticleByIdFromDB($articleId);

if (!$article) {
    header("HTTP/1.0 404 Not Found");
    echo "<h1>Статья не найдена</h1>";
    exit;
}

// Увеличиваем просмотры
incrementArticleViewsInDB($articleId);
$article['views']++; // Обновляем локально для отображения

// Получаем теги статьи
$tags = getArticleTagsFromDB($articleId);

// Функции форматирования
function formatDate($date) {
    return date('d F Y в H:i', strtotime($date));
}

function formatViews($views) {
    if ($views < 1000) return $views;
    if ($views < 1000000) return round($views / 1000, 1) . 'K';
    return round($views / 1000000, 1) . 'M';
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($article['title']) ?> | IT Blog</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <nav class="breadcrumb">
            <a href="index.php">← Назад к статьям</a>
        </nav>
        
        <!-- Заголовок статьи -->
        <header class="article-header">
            <h1 class="article-title"><?= htmlspecialchars($article['title']) ?></h1>
            <p class="article-excerpt"><?= htmlspecialchars($article['excerpt']) ?></p>
            
            <div class="article-info">
                <div class="info-item">
                    <strong>Автор:</strong> <?= htmlspecialchars($article['author_name']) ?>
                </div>
                <div class="info-item">
                    <strong>Категория:</strong> <?= htmlspecialchars($article['category_name']) ?>
                </div>
                <div class="info-item">
                    <strong>Дата:</strong> <?= formatDate($article['created_at']) ?>
                </div>
                <div class="info-item">
                    <strong>Время чтения:</strong> <?= $article['reading_time'] ?> мин
                </div>
                <div class="info-item">
                    <strong>Просмотров:</strong> <?= formatViews($article['views']) ?>
                </div>
            </div>
            
            <!-- Теги -->
            <?php if (!empty($tags)): ?>
            <div class="article-tags">
                <?php foreach ($tags as $tag): ?>
                    <span class="tag"><?= htmlspecialchars($tag['name']) ?></span>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </header>
        
        <!-- Содержимое статьи -->
        <main class="article-content">
            <div class="article-text">
                <?= nl2br(htmlspecialchars($article['content'])) ?>
            </div>
        </main>
        
        <!-- Автор -->
        <section class="author-info">
            <h3>Об авторе</h3>
            <div class="author-card">
                <div class="author-avatar">
                    <?= strtoupper(substr($article['author_name'], 0, 1)) ?>
                </div>
                <div class="author-details">
                    <h4><?= htmlspecialchars($article['author_name']) ?></h4>
                    <p><?= htmlspecialchars($article['author_email']) ?></p>
                    <?php if ($article['author_bio']): ?>
                        <p><?= htmlspecialchars($article['author_bio']) ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        
        <!-- Похожие статьи той же категории -->
        <?php
        $similarArticles = getArticlesByCategoryFromDB($article['category_id']);
        // Убираем текущую статью и ограничиваем до 3
        $similarArticles = array_filter($similarArticles, function($a) use ($articleId) {
            return $a['id'] != $articleId;
        });
        $similarArticles = array_slice($similarArticles, 0, 3);
        ?>
        
        <?php if (!empty($similarArticles)): ?>
        <section class="similar-articles">
            <h3>📖 Похожие статьи из категории "<?= htmlspecialchars($article['category_name']) ?>"</h3>
            <div class="similar-grid">
                <?php foreach ($similarArticles as $similar): ?>
                <article class="similar-card">
                    <h4>
                        <a href="article.php?id=<?= $similar['id'] ?>">
                            <?= htmlspecialchars($similar['title']) ?>
                        </a>
                    </h4>
                    <p class="similar-meta">
                        👁️ <?= formatViews($similar['views']) ?> • 
                        ⏱️ <?= $similar['reading_time'] ?> мин
                    </p>
                </article>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>
    </div>
</body>
</html>