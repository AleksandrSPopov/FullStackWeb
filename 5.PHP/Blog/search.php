<?php
/**
 * Поиск статей с MySQL
 */

require_once 'database/db_functions.php';

// Получаем поисковый запрос
$query = isset($_GET['q']) ? trim($_GET['q']) : '';

// Выполняем поиск
$searchResults = [];
if (!empty($query)) {
    $searchResults = searchArticlesInDB($query);
}

$totalResults = count($searchResults);

function formatDate($date) {
    return date('d.m.Y', strtotime($date));
}

function formatViews($views) {
    if ($views < 1000) return $views;
    return round($views / 1000, 1) . 'K';
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Поиск<?= $query ? ': ' . htmlspecialchars($query) : '' ?> | IT Blog</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <nav class="breadcrumb">
            <a href="index.php">← Назад на главную</a>
        </nav>
        
        <header class="search-header">
            <h1>🔍 Поиск по блогу</h1>
            
            <!-- Форма поиска -->
            <form method="GET" class="search-form">
                <input 
                    type="text" 
                    name="q" 
                    class="search-input" 
                    placeholder="Введите поисковый запрос..." 
                    value="<?= htmlspecialchars($query) ?>"
                    autofocus
                >
                <button type="submit" class="search-btn">Найти</button>
            </form>
        </header>
        
        <!-- Результаты поиска -->
        <main class="search-results">
            <?php if ($query): ?>
                <div class="results-info">
                    <h2>Результаты поиска</h2>
                    <p>
                        <?php if ($totalResults > 0): ?>
                            Найдено <strong><?= $totalResults ?></strong> 
                            <?= $totalResults == 1 ? 'статья' : 'статей' ?> 
                            по запросу "<strong><?= htmlspecialchars($query) ?></strong>"
                        <?php else: ?>
                            По запросу "<strong><?= htmlspecialchars($query) ?></strong>" ничего не найдено
                        <?php endif; ?>
                    </p>
                </div>
                
                <?php if ($totalResults > 0): ?>
                    <div class="results-grid">
                        <?php foreach ($searchResults as $article): ?>
                        <article class="result-card">
                            <h3 class="result-title">
                                <a href="article.php?id=<?= $article['id'] ?>">
                                    <?= htmlspecialchars($article['title']) ?>
                                </a>
                            </h3>
                            
                            <p class="result-excerpt">
                                <?= htmlspecialchars($article['excerpt']) ?>
                            </p>
                            
                            <div class="result-meta">
                                <span>👤 <?= htmlspecialchars($article['author_name']) ?></span>
                                <span>📁 <?= htmlspecialchars($article['category_name']) ?></span>
                                <span>📅 <?= formatDate($article['created_at']) ?></span>
                                <span>👁️ <?= formatViews($article['views']) ?></span>
                                <span>⏱️ <?= $article['reading_time'] ?> мин</span>
                            </div>
                        </article>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="no-results">
                        <h3>😔 К сожалению, ничего не найдено</h3>
                        <p>Попробуйте:</p>
                        <ul>
                            <li>Проверить правильность написания</li>
                            <li>Использовать более общие термины</li>
                            <li>Попробовать другие ключевые слова</li>
                        </ul>
                        <a href="index.php" class="btn">Посмотреть все статьи</a>
                    </div>
                <?php endif; ?>
                
            <?php else: ?>
                <div class="search-help">
                    <h2>Поиск статей</h2>
                    <p>Введите ключевые слова для поиска статей в нашем блоге.</p>
                    <p><strong>Преимущества поиска с MySQL:</strong></p>
                    <ul>
                        <li>⚡ Быстрый поиск по всем полям</li>
                        <li>🎯 Точные результаты</li>
                        <li>📊 Сортировка по релевантности</li>
                        <li>🔍 Поиск в заголовках, содержимом и описаниях</li>
                    </ul>
                </div>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>