<?php
/**
 * Главная страница блога с MySQL
 */

require_once 'database/db_functions.php';

// Получаем данные из БД
$allArticles = getAllArticlesFromDB();
$stats = getBlogStatsFromDB();

// Функция для форматирования просмотров
function formatViews($views) {
    if ($views < 1000) return $views;
    if ($views < 1000000) return round($views / 1000, 1) . 'K';
    return round($views / 1000000, 1) . 'M';
}

// Функция для форматирования даты
function formatDate($date) {
    return date('d.m.Y', strtotime($date));
}

// Функция для создания превью
function createExcerpt($text, $length = 150) {
    if (strlen($text) <= $length) return $text;
    return substr($text, 0, $length) . '...';
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Blog - Статьи о веб-разработке</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>🚀 IT Blog</h1>
            <p>Статьи о современной веб-разработке</p>
            <nav>
                <a href="index.php">Главная</a>
                <a href="search.php">Поиск</a>
                <a href="admin.php">Админ</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <!-- Статистика -->
        <section class="stats">
            <div class="stat-item">
                <h3><?= $stats['articles'] ?></h3>
                <p>Статей</p>
            </div>
            <div class="stat-item">
                <h3><?= formatViews($stats['views']) ?></h3>
                <p>Просмотров</p>
            </div>
            <div class="stat-item">
                <h3><?= $stats['authors'] ?></h3>
                <p>Авторов</p>
            </div>
            <div class="stat-item">
                <h3><?= $stats['categories'] ?></h3>
                <p>Категорий</p>
            </div>
        </section>

        <!-- Поиск -->
        <section class="search-section">
            <form action="search.php" method="GET" class="search-form">
                <input type="text" name="q" placeholder="Поиск статей..." class="search-input">
                <button type="submit" class="search-btn">Найти</button>
            </form>
        </section>

        <!-- Статьи -->
        <section class="articles">
            <h2>📚 Все статьи</h2>
            
            <?php if (empty($allArticles)): ?>
                <p>Статьи не найдены. <a href="database/migrate_data.php">Выполнить миграцию данных</a></p>
            <?php else: ?>
                <div class="articles-grid">
                    <?php foreach ($allArticles as $article): ?>
                    <article class="article-card">
                        <div class="article-header">
                            <h3 class="article-title">
                                <a href="article.php?id=<?= $article['id'] ?>">
                                    <?= htmlspecialchars($article['title']) ?>
                                </a>
                            </h3>
                            <p class="article-excerpt">
                                <?= htmlspecialchars($article['excerpt']) ?>
                            </p>
                        </div>
                        
                        <div class="article-meta">
                            <span>👤 <?= htmlspecialchars($article['author_name']) ?></span>
                            <span>📁 <?= htmlspecialchars($article['category_name']) ?></span>
                            <span>📅 <?= formatDate($article['created_at']) ?></span>
                        </div>
                        
                        <div class="article-stats">
                            <span>👁️ <?= formatViews($article['views']) ?></span>
                            <span>⏱️ <?= $article['reading_time'] ?> мин</span>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 IT Blog. Работает на MySQL!</p>
        </div>
    </footer>
</body>
</html>