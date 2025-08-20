<?php
// blog_data.php - данные нашего блога

// Массив авторов
$authors = [
    1 => [
        'id' => 1,
        'name' => 'Анна Разработчик',
        'email' => 'anna@blog.ru',
        'bio' => 'Senior PHP разработчик с 8-летним опытом. Специализируется на создании высоконагруженных веб-приложений.',
        'avatar' => 'authors/anna.jpg',
        'social' => [
            'github' => 'https://github.com/anna-dev',
            'telegram' => '@anna_developer'
        ]
    ],
    2 => [
        'id' => 2,
        'name' => 'Дмитрий Архитектор',
        'email' => 'dmitry@blog.ru',
        'bio' => 'Технический архитектор и fullstack разработчик. Эксперт по микросервисной архитектуре.',
        'avatar' => 'authors/dmitry.jpg',
        'social' => [
            'github' => 'https://github.com/dmitry-arch',
            'linkedin' => 'https://linkedin.com/in/dmitry-architect'
        ]
    ],
    3 => [
        'id' => 3,
        'name' => 'Мария Фронтенд',
        'email' => 'maria@blog.ru',
        'bio' => 'Frontend разработчик, UI/UX дизайнер. Создает красивые и функциональные интерфейсы.',
        'avatar' => 'authors/maria.jpg',
        'social' => [
            'behance' => 'https://behance.net/maria-frontend',
            'instagram' => '@maria_ui_ux'
        ]
    ]
];

// Массив категорий
$categories = [
    1 => ['id' => 1, 'name' => 'PHP и Backend', 'slug' => 'php-backend', 'description' => 'Статьи о серверной разработке на PHP'],
    2 => ['id' => 2, 'name' => 'Frontend', 'slug' => 'frontend', 'description' => 'HTML, CSS, JavaScript и современные фреймворки'],
    3 => ['id' => 3, 'name' => 'Базы данных', 'slug' => 'databases', 'description' => 'MySQL, PostgreSQL, NoSQL и оптимизация запросов'],
    4 => ['id' => 4, 'name' => 'DevOps', 'slug' => 'devops', 'description' => 'Deployment, CI/CD, контейнеризация'],
    5 => ['id' => 5, 'name' => 'Карьера в IT', 'slug' => 'career', 'description' => 'Советы по развитию карьеры в сфере IT']
];

// Массив тегов
$tags = [
    1 => ['id' => 1, 'name' => 'PHP', 'slug' => 'php'],
    2 => ['id' => 2, 'name' => 'MySQL', 'slug' => 'mysql'],
    3 => ['id' => 3, 'name' => 'JavaScript', 'slug' => 'javascript'],
    4 => ['id' => 4, 'name' => 'Laravel', 'slug' => 'laravel'],
    5 => ['id' => 5, 'name' => 'Vue.js', 'slug' => 'vuejs'],
    6 => ['id' => 6, 'name' => 'Docker', 'slug' => 'docker'],
    7 => ['id' => 7, 'name' => 'API', 'slug' => 'api'],
    8 => ['id' => 8, 'name' => 'Безопасность', 'slug' => 'security'],
    9 => ['id' => 9, 'name' => 'Производительность', 'slug' => 'performance'],
    10 => ['id' => 10, 'name' => 'Тестирование', 'slug' => 'testing']
];

// Массив статей
$articles = [
    1 => [
        'id' => 1,
        'title' => 'Основы PHP 8: Новые возможности и улучшения',
        'slug' => 'osnovy-php-8-novye-vozmozhnosti',
        'content' => 'PHP 8 принес множество долгожданных изменений и новых возможностей. В этой статье мы разберем ключевые нововведения: JIT-компилятор, Union Types, Named Arguments, Attributes и многое другое. JIT-компилятор значительно ускоряет выполнение математических операций и циклов. Union Types позволяют указывать несколько типов для одного параметра или возвращаемого значения. Named Arguments делают код более читаемым при вызове функций с множеством параметров.',
        'excerpt' => 'Обзор ключевых нововведений PHP 8: JIT-компилятор, Union Types, Named Arguments и другие важные улучшения.',
        'author_id' => 1,
        'category_id' => 1,
        'tag_ids' => [1, 9],
        'meta' => [
            'views' => 1247,
            'likes' => 89,
            'comments_count' => 23,
            'reading_time' => 8
        ],
        'dates' => [
            'created' => '2025-07-10 09:30:00',
            'updated' => '2025-07-11 14:15:00',
            'published' => '2025-07-10 12:00:00'
        ],
        'status' => 'published',
        'featured' => true,
        'featured_image' => 'articles/php8-features.jpg'
    ],
    
    2 => [
        'id' => 2,
        'title' => 'Создание REST API на PHP: Полное руководство',
        'slug' => 'sozdanie-rest-api-na-php',
        'content' => 'В современной веб-разработке API играют ключевую роль. В этом подробном руководстве мы создадим полноценное REST API на чистом PHP. Рассмотрим принципы REST архитектуры, правильную структуру URL, обработку HTTP методов (GET, POST, PUT, DELETE), аутентификацию через JWT токены, валидацию данных и обработку ошибок. Также затронем вопросы безопасности API и документирования эндпоинтов.',
        'excerpt' => 'Пошаговое создание REST API на PHP с примерами кода, аутентификацией и лучшими практиками.',
        'author_id' => 1,
        'category_id' => 1,
        'tag_ids' => [1, 7, 8],
        'meta' => [
            'views' => 892,
            'likes' => 67,
            'comments_count' => 15,
            'reading_time' => 12
        ],
        'dates' => [
            'created' => '2025-07-12 16:20:00',
            'updated' => '2025-07-13 10:30:00',
            'published' => '2025-07-12 18:00:00'
        ],
        'status' => 'published',
        'featured' => false,
        'featured_image' => 'articles/rest-api-php.jpg'
    ],
    
    3 => [
        'id' => 3,
        'title' => 'MySQL оптимизация: Как ускорить запросы в 10 раз',
        'slug' => 'mysql-optimizaciya-uskorenie-zaprosov',
        'content' => 'Производительность базы данных - критически важный аспект любого веб-приложения. В этой статье мы разберем продвинутые техники оптимизации MySQL: создание правильных индексов, анализ планов выполнения запросов с помощью EXPLAIN, оптимизация JOIN операций, настройка конфигурации сервера MySQL, партиционирование таблиц и кэширование результатов. Приведем реальные примеры оптимизации медленных запросов.',
        'excerpt' => 'Практические техники оптимизации MySQL для значительного увеличения производительности приложений.',
        'author_id' => 2,
        'category_id' => 3,
        'tag_ids' => [2, 9],
        'meta' => [
            'views' => 734,
            'likes' => 56,
            'comments_count' => 19,
            'reading_time' => 10
        ],
        'dates' => [
            'created' => '2025-07-08 11:45:00',
            'updated' => '2025-07-09 09:20:00',
            'published' => '2025-07-08 15:30:00'
        ],
        'status' => 'published',
        'featured' => true,
        'featured_image' => 'articles/mysql-optimization.jpg'
    ],
    
    4 => [
        'id' => 4,
        'title' => 'Vue.js 3 Composition API: Современный подход к разработке',
        'slug' => 'vuejs-3-composition-api',
        'content' => 'Vue.js 3 представил революционный Composition API, который меняет подход к написанию компонентов. Изучаем новые возможности: функции setup(), реактивность с ref() и reactive(), computed свойства, watchers, жизненный цикл компонентов в новом API. Сравниваем с Options API, рассматриваем случаи использования и миграцию существующих проектов. Практические примеры создания переиспользуемых композиций.',
        'excerpt' => 'Глубокое погружение в Composition API Vue.js 3 с практическими примерами и лучшими практиками.',
        'author_id' => 3,
        'category_id' => 2,
        'tag_ids' => [3, 5],
        'meta' => [
            'views' => 623,
            'likes' => 42,
            'comments_count' => 12,
            'reading_time' => 9
        ],
        'dates' => [
            'created' => '2025-07-14 14:10:00',
            'updated' => '2025-07-15 08:45:00',
            'published' => '2025-07-14 16:00:00'
        ],
        'status' => 'published',
        'featured' => false,
        'featured_image' => 'articles/vuejs3-composition.jpg'
    ],
    
    5 => [
        'id' => 5,
        'title' => 'Docker для PHP разработчиков: От основ до продакшена',
        'slug' => 'docker-dlya-php-razrabotchikov',
        'content' => 'Контейнеризация стала стандартом современной разработки. В этом руководстве изучаем Docker применительно к PHP проектам: создание Dockerfile для PHP приложений, настройка docker-compose для локальной разработки, работа с базами данных в контейнерах, multi-stage builds для оптимизации образов, деплой в production с помощью Docker Swarm или Kubernetes. Настройка CI/CD пайплайнов с Docker.',
        'excerpt' => 'Полное руководство по использованию Docker в PHP разработке от локальной среды до продакшена.',
        'author_id' => 2,
        'category_id' => 4,
        'tag_ids' => [1, 6],
        'meta' => [
            'views' => 445,
            'likes' => 38,
            'comments_count' => 8,
            'reading_time' => 15
        ],
        'dates' => [
            'created' => '2025-07-11 12:30:00',
            'updated' => '2025-07-12 16:20:00',
            'published' => '2025-07-11 18:00:00'
        ],
        'status' => 'published',
        'featured' => false,
        'featured_image' => 'articles/docker-php.jpg'
    ],
    
    6 => [
        'id' => 6,
        'title' => 'Laravel 10: Что нового и стоит ли обновляться?',
        'slug' => 'laravel-10-chto-novogo',
        'content' => 'Laravel 10 принес множество улучшений и новых возможностей. Разбираем нововведения: улучшенная производительность, новые Artisan команды, обновленный Eloquent ORM, улучшения в системе валидации, новые возможности Blade компонентов, интеграция с современными frontend фреймворками. Руководство по миграции с Laravel 9, потенциальные проблемы и их решения. Оценка целесообразности обновления для разных типов проектов.',
        'excerpt' => 'Обзор новых возможностей Laravel 10 и практические советы по миграции с предыдущих версий.',
        'author_id' => 1,
        'category_id' => 1,
        'tag_ids' => [1, 4],
        'meta' => [
            'views' => 567,
            'likes' => 44,
            'comments_count' => 11,
            'reading_time' => 7
        ],
        'dates' => [
            'created' => '2025-07-13 10:15:00',
            'updated' => '2025-07-14 12:30:00',
            'published' => '2025-07-13 14:00:00'
        ],
        'status' => 'published',
        'featured' => false,
        'featured_image' => 'articles/laravel-10.jpg'
    ],
    
    7 => [
        'id' => 7,
        'title' => 'Безопасность веб-приложений: Топ-10 уязвимостей 2025',
        'slug' => 'bezopasnost-veb-prilozhenij-top-10',
        'content' => 'Кибербезопасность становится все более критичной. Рассматриваем актуальный список OWASP Top 10 уязвимостей 2025 года: injection атаки, broken authentication, XSS, CSRF, security misconfigurations и другие. Для каждой уязвимости приводим примеры эксплуатации и методы защиты. Практические рекомендации по созданию безопасных PHP приложений: валидация входных данных, prepared statements, CSP headers, безопасные сессии.',
        'excerpt' => 'Актуальный обзор основных угроз веб-безопасности и практические методы защиты PHP приложений.',
        'author_id' => 2,
        'category_id' => 1,
        'tag_ids' => [1, 8],
        'meta' => [
            'views' => 789,
            'likes' => 65,
            'comments_count' => 16,
            'reading_time' => 11
        ],
        'dates' => [
            'created' => '2025-07-09 15:20:00',
            'updated' => '2025-07-10 11:45:00',
            'published' => '2025-07-09 18:30:00'
        ],
        'status' => 'published',
        'featured' => true,
        'featured_image' => 'articles/web-security.jpg'
    ],
    
    8 => [
        'id' => 8,
        'title' => 'Тестирование в PHP: PHPUnit, Pest и лучшие практики',
        'slug' => 'testirovanie-php-phpunit-pest',
        'content' => 'Качественное тестирование - основа надежного кода. Изучаем современные инструменты тестирования PHP: классический PHPUnit и новый фреймворк Pest. Рассматриваем типы тестов: unit, integration, feature тесты. Мокирование зависимостей, тестирование баз данных, API endpoints. Настройка CI/CD для автоматического запуска тестов. TDD и BDD подходы. Измерение покрытия кода тестами и интерпретация метрик.',
        'excerpt' => 'Комплексное руководство по тестированию PHP приложений с современными инструментами и методологиями.',
        'author_id' => 1,
        'category_id' => 1,
        'tag_ids' => [1, 10],
        'meta' => [
            'views' => 398,
            'likes' => 29,
            'comments_count' => 7,
            'reading_time' => 13
        ],
        'dates' => [
            'created' => '2025-07-15 09:40:00',
            'updated' => '2025-07-16 14:20:00',
            'published' => '2025-07-15 12:00:00'
        ],
        'status' => 'published',
        'featured' => false,
        'featured_image' => 'articles/php-testing.jpg'
    ],
    
    9 => [
        'id' => 9,
        'title' => 'Карьерный путь PHP разработчика в 2025 году',
        'slug' => 'karjernyj-put-php-razrabotchika-2025',
        'content' => 'Рынок PHP разработки продолжает эволюционировать. Анализируем текущее состояние и перспективы: востребованные навыки, зарплатные ожидания в разных регионах, популярные стеки технологий. Roadmap развития от Junior до Senior и далее: технические и soft skills, важность open source вклада, построение личного бренда. Советы по поиску работы, подготовке к собеседованиям, переговорам о зарплате. Альтернативные пути: фриланс, продуктовые компании, стартапы.',
        'excerpt' => 'Актуальный гид по развитию карьеры PHP разработчика с практическими советами и market insights.',
        'author_id' => 3,
        'category_id' => 5,
        'tag_ids' => [1],
        'meta' => [
            'views' => 512,
            'likes' => 47,
            'comments_count' => 18,
            'reading_time' => 6
        ],
        'dates' => [
            'created' => '2025-07-16 13:25:00',
            'updated' => '2025-07-16 15:10:00',
            'published' => '2025-07-16 16:00:00'
        ],
        'status' => 'published',
        'featured' => false,
        'featured_image' => 'articles/php-career-2025.jpg'
    ],
    
    10 => [
        'id' => 10,
        'title' => 'Микросервисы на PHP: Архитектура и практическая реализация',
        'slug' => 'mikroservisy-na-php-arhitektura',
        'content' => 'Микросервисная архитектура становится стандартом для крупных проектов. Изучаем принципы построения микросервисов на PHP: декомпозиция монолита, межсервисное взаимодействие через HTTP API и message queues, управление конфигурацией, логирование и мониторинг распределенных систем. Service mesh, circuit breaker pattern, eventual consistency. Инструменты для разработки: Docker, Kubernetes, API Gateway. Практический пример разбиения e-commerce системы на микросервисы.',
        'excerpt' => 'Глубокое погружение в микросервисную архитектуру с практическими примерами реализации на PHP.',
        'author_id' => 2,
        'category_id' => 1,
        'tag_ids' => [1, 7, 6],
        'meta' => [
            'views' => 334,
            'likes' => 31,
            'comments_count' => 9,
            'reading_time' => 18
        ],
        'dates' => [
            'created' => '2025-07-17 08:15:00',
            'updated' => '2025-07-17 10:30:00',
            'published' => '2025-07-17 11:00:00'
        ],
        'status' => 'published',
        'featured' => true,
        'featured_image' => 'articles/php-microservices.jpg'
    ]
];

// Функции для работы с данными
function getAuthorById($id) {
    global $authors;
    return $authors[$id] ?? null;
}

function getCategoryById($id) {
    global $categories;
    return $categories[$id] ?? null;
}

function getTagsByIds($ids) {
    global $tags;
    return array_filter($tags, function($tag) use ($ids) {
        return in_array($tag['id'], $ids);
    });
}

function getArticleWithRelations($articleId) {
    global $articles;
    
    if (!isset($articles[$articleId])) {
        return null;
    }
    
    $article = $articles[$articleId];
    
    // Добавляем связанные данные
    $article['author'] = getAuthorById($article['author_id']);
    $article['category'] = getCategoryById($article['category_id']);
    $article['tags'] = getTagsByIds($article['tag_ids']);
    
    return $article;
}
?>