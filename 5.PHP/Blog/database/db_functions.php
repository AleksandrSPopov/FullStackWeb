<?php
/**
 * Функции для работы с базой данных
 */

// Глобальная переменная для PDO соединения
$pdo = null;

/**
 * Получение соединения с БД
 */
function getDbConnection() {
    global $pdo;
    
    if ($pdo === null) {
        try {
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
        } catch (PDOException $e) {
            die("Ошибка подключения к БД: " . $e->getMessage());
        }
    }
    
    return $pdo;
}

/**
 * Получение всех статей
 */
function getAllArticlesFromDB($limit = null, $offset = 0) {
    $pdo = getDbConnection();
    
    $sql = "
        SELECT a.\*, u.name as author_name, u.email as author_email,
               c.name as category_name, c.slug as category_slug
        FROM articles a
        JOIN users u ON a.author_id = u.id
        JOIN categories c ON a.category_id = c.id
        WHERE a.status = 'published'
        ORDER BY a.created_at DESC
    ";
    
    if ($limit) {
        $sql .= " LIMIT :limit OFFSET :offset";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    } else {
        $stmt = $pdo->prepare($sql);
    }
    
    $stmt->execute();
    return $stmt->fetchAll();
}

/**
 * Получение статьи по ID
 */
function getArticleByIdFromDB($id) {
    $pdo = getDbConnection();
    
    $stmt = $pdo->prepare("
        SELECT a.\*, u.name as author_name, u.email as author_email, u.bio as author_bio,
               c.name as category_name, c.slug as category_slug
        FROM articles a
        JOIN users u ON a.author_id = u.id
        JOIN categories c ON a.category_id = c.id
        WHERE a.id = :id AND a.status = 'published'
    ");
    
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetch();
}

/**
 * Получение тегов для статьи
 */
function getArticleTagsFromDB($articleId) {
    $pdo = getDbConnection();
    
    $stmt = $pdo->prepare("
        SELECT t.id, t.name, t.slug
        FROM tags t
        JOIN article_tags at ON t.id = at.tag_id
        WHERE at.article_id = :article_id
    ");
    
    $stmt->bindParam(':article_id', $articleId, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll();
}

/**
 * Увеличение просмотров статьи
 */
function incrementArticleViewsInDB($articleId) {
    $pdo = getDbConnection();
    
    $stmt = $pdo->prepare("UPDATE articles SET views = views + 1 WHERE id = :id");
    $stmt->bindParam(':id', $articleId, PDO::PARAM_INT);
    
    return $stmt->execute();
}

/**
 * Поиск статей
 */
function searchArticlesInDB($query) {
    $pdo = getDbConnection();
    
    $stmt = $pdo->prepare("
        SELECT a.\*, u.name as author_name, c.name as category_name
        FROM articles a
        JOIN users u ON a.author_id = u.id
        JOIN categories c ON a.category_id = c.id
        WHERE (a.title LIKE :query OR a.content LIKE :query OR a.excerpt LIKE :query)
        AND a.status = 'published'
        ORDER BY a.created_at DESC
    ");
    
    $searchParam = "%$query%";
    $stmt->bindParam(':query', $searchParam);
    $stmt->execute();
    
    return $stmt->fetchAll();
}

/**
 * Получение статей по категории
 */
function getArticlesByCategoryFromDB($categoryId) {
    $pdo = getDbConnection();
    
    $stmt = $pdo->prepare("
        SELECT a.\*, u.name as author_name, c.name as category_name
        FROM articles a
        JOIN users u ON a.author_id = u.id
        JOIN categories c ON a.category_id = c.id
        WHERE a.category_id = :category_id AND a.status = 'published'
        ORDER BY a.created_at DESC
    ");
    
    $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll();
}

/**
 * Создание новой статьи
 */
function createArticleInDB($data) {
    $pdo = getDbConnection();
    
    try {
        $pdo->beginTransaction();
        
        // Вставляем статью
        $stmt = $pdo->prepare("
            INSERT INTO articles (title, slug, content, excerpt, author_id, category_id, reading_time)
            VALUES (:title, :slug, :content, :excerpt, :author_id, :category_id, :reading_time)
        ");
        
        $stmt->execute([
            ':title' => $data['title'],
            ':slug' => $data['slug'],
            ':content' => $data['content'],
            ':excerpt' => $data['excerpt'],
            ':author_id' => $data['author_id'],
            ':category_id' => $data['category_id'],
            ':reading_time' => $data['reading_time']
        ]);
        
        $articleId = $pdo->lastInsertId();
        
        // Добавляем теги если есть
        if (!empty($data['tags'])) {
            foreach ($data['tags'] as $tagId) {
                $stmt = $pdo->prepare("INSERT INTO article_tags (article_id, tag_id) VALUES (?, ?)");
                $stmt->execute([$articleId, $tagId]);
            }
        }
        
        $pdo->commit();
        return $articleId;
        
    } catch (Exception $e) {
        $pdo->rollback();
        return false;
    }
}

/**
 * Получение статистики блога
 */
function getBlogStatsFromDB() {
    $pdo = getDbConnection();
    
    // Общее количество статей
    $stmt = $pdo->query("SELECT COUNT(\*) FROM articles WHERE status = 'published'");
    $totalArticles = $stmt->fetchColumn();
    
    // Общее количество просмотров
    $stmt = $pdo->query("SELECT SUM(views) FROM articles WHERE status = 'published'");
    $totalViews = $stmt->fetchColumn() ?? 0;
    
    // Количество авторов
    $stmt = $pdo->query("SELECT COUNT(\*) FROM users");
    $totalAuthors = $stmt->fetchColumn();
    
    // Количество категорий
    $stmt = $pdo->query("SELECT COUNT(\*) FROM categories");
    $totalCategories = $stmt->fetchColumn();
    
    return [
        'articles' => $totalArticles,
        'views' => $totalViews,
        'authors' => $totalAuthors,
        'categories' => $totalCategories
    ];
}
?>