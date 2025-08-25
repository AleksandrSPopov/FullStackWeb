<?php
/**
 * Миграция данных из файлов в MySQL
 */

require_once '../data.php';
require_once '../functions.php';
require_once 'db_functions.php';

echo "<h2>🔄 Миграция данных из файлов в MySQL</h2>";

$pdo = getDbConnection();

try {
    $pdo->beginTransaction();
    
    // ========================================================================
    // 1. МИГРАЦИЯ АВТОРОВ
    // ========================================================================
    
    echo "<h3>👥 Миграция авторов</h3>";
    
    $authors = getAuthors();
    $authorMapping = []; // Старый ID => Новый ID
    
    foreach ($authors as $oldId => $author) {
        $stmt = $pdo->prepare("
            INSERT INTO users (name, email, bio) 
            VALUES (:name, :email, :bio)
        ");
        
        $stmt->execute([
            ':name' => $author['name'],
            ':email' => $author['email'],
            ':bio' => $author['bio']
        ]);
        
        $newId = $pdo->lastInsertId();
        $authorMapping[$oldId] = $newId;
        
        echo "✅ Автор '{$author['name']}': $oldId → $newId<br>";
    }
    
    // ========================================================================
    // 2. МИГРАЦИЯ КАТЕГОРИЙ
    // ========================================================================
    
    echo "<h3>📁 Миграция категорий</h3>";
    
    $categories = getCategories();
    $categoryMapping = [];
    
    foreach ($categories as $oldId => $categoryName) {
        $slug = strtolower(str_replace(' ', '-', $categoryName));
        $slug = preg_replace('/\[^a-z0-9\\-\]/', '', $slug);
        
        $stmt = $pdo->prepare("
            INSERT INTO categories (name, slug, description) 
            VALUES (:name, :slug, :description)
        ");
        
        $stmt->execute([
            ':name' => $categoryName,
            ':slug' => $slug,
            ':description' => "Категория: $categoryName"
        ]);
        
        $newId = $pdo->lastInsertId();
        $categoryMapping[$oldId] = $newId;
        
        echo "✅ Категория '$categoryName': $oldId → $newId<br>";
    }
    
    // ========================================================================
    // 3. СБОР И СОЗДАНИЕ ТЕГОВ
    // ========================================================================
    
    echo "<h3>🏷️ Создание тегов</h3>";
    
    $allTags = getAllTags();
    $tagMapping = []; // Имя тега => ID
    
    foreach ($allTags as $tagName) {
        $slug = strtolower(str_replace(' ', '-', $tagName));
        $slug = preg_replace('/\[^a-z0-9\\-\]/', '', $slug);
        
        $stmt = $pdo->prepare("
            INSERT INTO tags (name, slug) 
            VALUES (:name, :slug)
        ");
        
        $stmt->execute([
            ':name' => $tagName,
            ':slug' => $slug
        ]);
        
        $newId = $pdo->lastInsertId();
        $tagMapping[$tagName] = $newId;
        
        echo "✅ Тег '$tagName' → $newId<br>";
    }
    
    // ========================================================================
    // 4. МИГРАЦИЯ СТАТЕЙ
    // ========================================================================
    
    echo "<h3>📚 Миграция статей</h3>";
    
    $allArticles = getAllArticles();
    
    foreach ($allArticles as $article) {
        // Создаем slug из заголовка
        $slug = strtolower($article['title']);
        $slug = str_replace([' ', 'ё'], ['-', 'e'], $slug);
        $slug = preg_replace('/\[^a-z0-9\\-\]/', '', $slug);
        
        // Подготавливаем данные
        $data = [
            ':title' => $article['title'],
            ':slug' => $slug,
            ':content' => $article['content'],
            ':excerpt' => $article['excerpt'],
            ':author_id' => $authorMapping[$article['author_id']],
            ':category_id' => $categoryMapping[$article['category_id']],
            ':reading_time' => $article['reading_time'],
            ':views' => $article['views'],
            ':created_at' => $article['date'] . ' 12:00:00'
        ];
        
        $stmt = $pdo->prepare("
            INSERT INTO articles (title, slug, content, excerpt, author_id, category_id, reading_time, views, created_at)
            VALUES (:title, :slug, :content, :excerpt, :author_id, :category_id, :reading_time, :views, :created_at)
        ");
        
        $stmt->execute($data);
        $newArticleId = $pdo->lastInsertId();
        
        // Добавляем теги для статьи
        if (!empty($article['tags'])) {
            foreach ($article['tags'] as $tagName) {
                if (isset($tagMapping[$tagName])) {
                    $stmt = $pdo->prepare("INSERT INTO article_tags (article_id, tag_id) VALUES (?, ?)");
                    $stmt->execute([$newArticleId, $tagMapping[$tagName]]);
                }
            }
        }
        
        echo "✅ Статья '{$article['title']}' → ID: $newArticleId<br>";
    }
    
    $pdo->commit();
    echo "<h3>🎉 Миграция завершена успешно!</h3>";
    
} catch (Exception $e) {
    $pdo->rollback();
    echo "<h3>❌ Ошибка миграции: " . $e->getMessage() . "</h3>";
}

// Выводим статистику
echo "<h3>📊 Статистика после миграции</h3>";
$stats = getBlogStatsFromDB();
echo "<ul>";
echo "<li>Статей: {$stats['articles']}</li>";
echo "<li>Просмотров: {$stats['views']}</li>";
echo "<li>Авторов: {$stats['authors']}</li>";
echo "<li>Категорий: {$stats['categories']}</li>";
echo "</ul>";
?>