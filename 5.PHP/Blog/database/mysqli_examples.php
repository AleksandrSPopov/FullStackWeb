<?php
/**
 * Примеры работы с MySQL через mysqli
 */

// Подключение к базе данных
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'blog_db';

// Создание соединения
$mysqli = new mysqli($host, $username, $password, $database);

// Проверка соединения
if ($mysqli->connect_error) {
    die('Ошибка подключения: ' . $mysqli->connect_error);
}

// Установка кодировки
$mysqli->set_charset('utf8mb4');

echo "<h2>Примеры работы с mysqli</h2>";

// ============================================================================
// ПРИМЕР 1: ПОЛУЧЕНИЕ ВСЕХ СТАТЕЙ
// ============================================================================

echo "<h3>📚 Все статьи</h3>";

$query = "SELECT a.id, a.title, a.excerpt, a.views, u.name as author_name 
          FROM articles a 
          JOIN users u ON a.author_id = u.id 
          ORDER BY a.created_at DESC";

$result = $mysqli->query($query);

if ($result) {
    echo "<table border='1' style='border-collapse: collapse;'>";
    echo "<tr><th>ID</th><th>Заголовок</th><th>Автор</th><th>Просмотры</th></tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['id']}</td>";
        echo "<td>" . htmlspecialchars($row['title']) . "</td>";
        echo "<td>" . htmlspecialchars($row['author_name']) . "</td>";
        echo "<td>{$row['views']}</td>";
        echo "</tr>";
    }
    
    echo "</table>";
} else {
    echo "Ошибка выполнения запроса: " . $mysqli->error;
}

// ============================================================================
// ПРИМЕР 2: ПОЛУЧЕНИЕ СТАТЬИ ПО ID (Prepared Statement)
// ============================================================================

echo "<h3>📖 Получение статьи по ID</h3>";

$articleId = 1; // В реальности берем из $_GET\['id'\]

// Подготовленный запрос (защита от SQL-инъекций)
$stmt = $mysqli->prepare("
    SELECT a.\*, u.name as author_name, u.email as author_email,
           c.name as category_name
    FROM articles a
    JOIN users u ON a.author_id = u.id
    JOIN categories c ON a.category_id = c.id
    WHERE a.id = ?
");

$stmt->bind_param("i", $articleId);
$stmt->execute();
$result = $stmt->get_result();

if ($article = $result->fetch_assoc()) {
    echo "<div style='border: 1px solid #ccc; padding: 15px; margin: 10px 0;'>";
    echo "<h4>" . htmlspecialchars($article['title']) . "</h4>";
    echo "<p><strong>Автор:</strong> " . htmlspecialchars($article['author_name']) . "</p>";
    echo "<p><strong>Категория:</strong> " . htmlspecialchars($article['category_name']) . "</p>";
    echo "<p><strong>Просмотров:</strong> {$article['views']}</p>";
    echo "<p>" . htmlspecialchars($article['excerpt']) . "</p>";
    echo "</div>";
} else {
    echo "Статья не найдена";
}

$stmt->close();

// ============================================================================
// ПРИМЕР 3: ДОБАВЛЕНИЕ НОВОЙ СТАТЬИ
// ============================================================================

echo "<h3>➕ Добавление новой статьи</h3>";

// Данные новой статьи
$newTitle = "Тестовая статья из PHP";
$newContent = "Это содержимое тестовой статьи, созданной через mysqli.";
$newExcerpt = "Короткое описание тестовой статьи.";
$authorId = 1;
$categoryId = 1;
$readingTime = 3;

$stmt = $mysqli->prepare("
    INSERT INTO articles (title, slug, content, excerpt, author_id, category_id, reading_time) 
    VALUES (?, ?, ?, ?, ?, ?, ?)
");

// Создаем slug из заголовка
$slug = strtolower(str_replace([' ', 'ё'], ['-', 'e'], $newTitle));
$slug = preg_replace('/\[^a-z0-9\\-\]/', '', $slug);

$stmt->bind_param("sssssii", $newTitle, $slug, $newContent, $newExcerpt, $authorId, $categoryId, $readingTime);

if ($stmt->execute()) {
    $newArticleId = $mysqli->insert_id;
    echo "✅ Статья успешно добавлена с ID: $newArticleId";
} else {
    echo "❌ Ошибка добавления статьи: " . $stmt->error;
}

$stmt->close();

// ============================================================================
// ПРИМЕР 4: ОБНОВЛЕНИЕ ПРОСМОТРОВ
// ============================================================================

echo "<h3>👁️ Увеличение просмотров</h3>";

$viewArticleId = 1;

$stmt = $mysqli->prepare("UPDATE articles SET views = views + 1 WHERE id = ?");
$stmt->bind_param("i", $viewArticleId);

if ($stmt->execute()) {
    echo "✅ Просмотры увеличены для статьи ID: $viewArticleId";
    
    // Получаем новое значение
    $result = $mysqli->query("SELECT views FROM articles WHERE id = $viewArticleId");
    $row = $result->fetch_assoc();
    echo " (новое значение: {$row['views']})";
} else {
    echo "❌ Ошибка обновления просмотров: " . $stmt->error;
}

$stmt->close();

// ============================================================================
// ПРИМЕР 5: СТАТИСТИКА
// ============================================================================

echo "<h3>📊 Статистика блога</h3>";

// Общее количество статей
$result = $mysqli->query("SELECT COUNT(\*) as total FROM articles");
$totalArticles = $result->fetch_assoc()['total'];

// Общее количество просмотров
$result = $mysqli->query("SELECT SUM(views) as total_views FROM articles");
$totalViews = $result->fetch_assoc()['total_views'];

// Самая популярная статья
$result = $mysqli->query("
    SELECT title, views 
    FROM articles 
    ORDER BY views DESC 
    LIMIT 1
");
$popularArticle = $result->fetch_assoc();

echo "<ul>";
echo "<li>Всего статей: $totalArticles</li>";
echo "<li>Всего просмотров: $totalViews</li>";
echo "<li>Самая популярная: " . htmlspecialchars($popularArticle['title']) . " ({$popularArticle['views']} просмотров)</li>";
echo "</ul>";

// Закрытие соединения
$mysqli->close();
?>