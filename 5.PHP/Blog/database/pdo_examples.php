<?php
/**
 * Примеры работы с MySQL через PDO
 */

try {
    // Создание соединения PDO
    $pdo = new PDO(
        "mysql:host=localhost;dbname=blog_db;charset=utf8mb4",
        'root',
        '',
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
    
    echo "<h2>Примеры работы с PDO</h2>";
    
    // ========================================================================
    // ПРИМЕР 1: ПОЛУЧЕНИЕ СТАТЕЙ С КАТЕГОРИЯМИ
    // ========================================================================
    
    echo "<h3>📚 Статьи по категориям</h3>";
    
    $stmt = $pdo->query("
        SELECT c.name as category, COUNT(a.id) as articles_count
        FROM categories c
        LEFT JOIN articles a ON c.id = a.category_id
        GROUP BY c.id, c.name
        ORDER BY articles_count DESC
    ");
    
    echo "<ul>";
    while ($row = $stmt->fetch()) {
        echo "<li>{$row['category']}: {$row['articles_count']} статей</li>";
    }
    echo "</ul>";
    
    // ========================================================================
    // ПРИМЕР 2: ПОИСК СТАТЕЙ (Prepared Statement)
    // ========================================================================
    
    echo "<h3>🔍 Поиск статей</h3>";
    
    $searchQuery = "PHP"; // В реальности из $_GET\['search'\]
    
    $stmt = $pdo->prepare("
        SELECT a.id, a.title, a.excerpt, u.name as author_name
        FROM articles a
        JOIN users u ON a.author_id = u.id
        WHERE a.title LIKE :search OR a.content LIKE :search
        ORDER BY a.created_at DESC
    ");
    
    $searchParam = "%$searchQuery%";
    $stmt->bindParam(':search', $searchParam);
    $stmt->execute();
    
    echo "<p>Найдено статей по запросу '<strong>$searchQuery</strong>': " . $stmt->rowCount() . "</p>";
    
    echo "<div>";
    while ($article = $stmt->fetch()) {
        echo "<div style='border: 1px solid #ddd; margin: 10px 0; padding: 15px;'>";
        echo "<h4>" . htmlspecialchars($article['title']) . "</h4>";
        echo "<p>Автор: " . htmlspecialchars($article['author_name']) . "</p>";
        echo "<p>" . htmlspecialchars($article['excerpt']) . "</p>";
        echo "</div>";
    }
    echo "</div>";
    
    // ========================================================================
    // ПРИМЕР 3: ТРАНЗАКЦИИ
    // ========================================================================
    
    echo "<h3>💾 Работа с транзакциями</h3>";
    
    try {
        // Начинаем транзакцию
        $pdo->beginTransaction();
        
        // Добавляем автора
        $stmt = $pdo->prepare("INSERT INTO users (name, email, bio) VALUES (?, ?, ?)");
        $stmt->execute(['Новый Автор', 'new@blog.ru', 'Биография нового автора']);
        $newAuthorId = $pdo->lastInsertId();
        
        // Добавляем статью этого автора
        $stmt = $pdo->prepare("
            INSERT INTO articles (title, slug, content, excerpt, author_id, category_id) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            'Статья нового автора',
            'statya-novogo-avtora',
            'Содержимое статьи от нового автора.',
            'Краткое описание статьи.',
            $newAuthorId,
            1
        ]);
        
        // Подтверждаем транзакцию
        $pdo->commit();
        
        echo "✅ Транзакция успешно выполнена. Добавлен автор ID: $newAuthorId";
        
    } catch (Exception $e) {
        // Откатываем транзакцию при ошибке
        $pdo->rollback();
        echo "❌ Ошибка транзакции: " . $e->getMessage();
    }
    
    // ========================================================================
    // ПРИМЕР 4: ПАГИНАЦИЯ
    // ========================================================================
    
    echo "<h3>📄 Пагинация статей</h3>";
    
    $page = 1; // Текущая страница (из $_GET\['page'\])
    $perPage = 2; // Статей на страницу
    $offset = ($page - 1) * $perPage;
    
    // Общее количество статей
    $totalStmt = $pdo->query("SELECT COUNT(\*) FROM articles");
    $totalArticles = $totalStmt->fetchColumn();
    $totalPages = ceil($totalArticles / $perPage);
    
    // Статьи для текущей страницы
    $stmt = $pdo->prepare("
        SELECT a.id, a.title, a.excerpt, u.name as author_name
        FROM articles a
        JOIN users u ON a.author_id = u.id
        ORDER BY a.created_at DESC
        LIMIT :limit OFFSET :offset
    ");
    
    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    
    echo "<p>Страница $page из $totalPages (всего статей: $totalArticles)</p>";
    
    while ($article = $stmt->fetch()) {
        echo "<div style='border: 1px solid #eee; margin: 5px 0; padding: 10px;'>";
        echo "<strong>" . htmlspecialchars($article['title']) . "</strong>";
        echo " - " . htmlspecialchars($article['author_name']);
        echo "</div>";
    }
    
    // ========================================================================
    // ПРИМЕР 5: РАБОТА С ТЕГАМИ (Many-to-Many)
    // ========================================================================
    
    echo "<h3>🏷️ Статьи с тегами</h3>";
    
    $stmt = $pdo->query("
        SELECT a.id, a.title,
               GROUP_CONCAT(t.name SEPARATOR ', ') as tags
        FROM articles a
        LEFT JOIN article_tags at ON a.id = at.article_id
        LEFT JOIN tags t ON at.tag_id = t.id
        GROUP BY a.id, a.title
        ORDER BY a.id
    ");
    
    echo "<ul>";
    while ($row = $stmt->fetch()) {
        echo "<li>";
        echo htmlspecialchars($row['title']);
        if ($row['tags']) {
            echo " <em>Теги: " . htmlspecialchars($row['tags']) . "</em>";
        }
        echo "</li>";
    }
    echo "</ul>";
    
} catch (PDOException $e) {
    echo "❌ Ошибка PDO: " . $e->getMessage();
}
?>