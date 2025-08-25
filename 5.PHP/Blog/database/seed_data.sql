-- Заполнение таблиц тестовыми данными

-- Вставка пользователей
INSERT INTO users (name, email, bio) VALUES
('Анна Разработчик', 'anna@blog.ru', 'Senior PHP разработчик с 8-летним опытом'),
('Дмитрий Архитектор', 'dmitry@blog.ru', 'Технический архитектор и fullstack разработчик'),
('Мария Фронтенд', 'maria@blog.ru', 'Frontend разработчик, UI/UX дизайнер');

-- Вставка категорий
INSERT INTO categories (name, slug, description) VALUES
('PHP и Backend', 'php-backend', 'Статьи о серверной разработке на PHP'),
('Frontend', 'frontend', 'HTML, CSS, JavaScript и современные фреймворки'),
('Базы данных', 'databases', 'MySQL, PostgreSQL, NoSQL и оптимизация запросов'),
('DevOps', 'devops', 'Deployment, CI/CD, контейнеризация');

-- Вставка тегов
INSERT INTO tags (name, slug) VALUES
('PHP', 'php'),
('JavaScript', 'javascript'),
('MySQL', 'mysql'),
('API', 'api'),
('Backend', 'backend'),
('Frontend', 'frontend'),
('Оптимизация', 'optimization');

-- Вставка статей
INSERT INTO articles (title, slug, content, excerpt, author_id, category_id, reading_time) VALUES
(
    'Основы PHP 8: Новые возможности',
    'osnovy-php-8-novye-vozmozhnosti',
    'PHP 8 принес множество долгожданных изменений. JIT-компилятор значительно ускоряет выполнение кода. Union Types позволяют указывать несколько типов для параметра. Named Arguments делают код более читаемым. Attributes заменяют комментарии-аннотации. Match expression - более мощная альтернатива switch. Nullsafe operator упрощает работу с цепочками вызовов. Все эти нововведения делают PHP более современным и производительным языком программирования.',
    'Обзор ключевых нововведений PHP 8: JIT, Union Types, Named Arguments',
    1, 1, 8
),
(
    'Создание REST API на PHP',
    'sozdanie-rest-api-na-php',
    'REST API - основа современных веб-приложений. Начнем с базовой структуры: создадим endpoints для GET, POST, PUT, DELETE операций. Важно правильно обрабатывать HTTP заголовки и коды ответов. Аутентификация через JWT токены обеспечит безопасность. Валидация входных данных защитит от ошибок. CORS настройки позволят работать с фронтендом. Документирование API через OpenAPI стандарт поможет другим разработчикам.',
    'Пошаговое создание REST API на PHP с примерами кода',
    1, 1, 12
),
(
    'MySQL оптимизация запросов',
    'mysql-optimizaciya-zaprosov',
    'Производительность БД критически важна. Индексы - первый шаг к оптимизации. EXPLAIN покажет план выполнения запроса. Избегайте SELECT \* в продакшене. JOIN операции требуют особого внимания к индексам. Денормализация иногда оправдана. Партицирование таблиц для больших объемов данных. Мониторинг slow query log выявит проблемные места. Кеширование на уровне приложения уменьшит нагрузку на БД.',
    'Техники оптимизации MySQL для увеличения производительности',
    2, 3, 10
),
(
    'JavaScript ES2024: Новинки года',
    'javascript-es2024-novinki-goda',
    'JavaScript продолжает развиваться. Array.with() позволяет создавать новые массивы с измененными элементами. Object.groupBy() упрощает группировку данных. Promise.withResolvers() дает больше контроля над промисами. Temporal API наконец заменит Date. Import attributes улучшают работу с модулями. Decorators стандартизируются. Эти нововведения делают JavaScript еще более мощным и удобным для разработки.',
    'Обзор новых возможностей JavaScript ES2024',
    3, 2, 6
);

-- Связывание статей с тегами
INSERT INTO article_tags (article_id, tag_id) VALUES
(1, 1), -- PHP 8 -> PHP
(1, 5), -- PHP 8 -> Backend
(2, 1), -- REST API -> PHP
(2, 4), -- REST API -> API
(2, 5), -- REST API -> Backend
(3, 3), -- MySQL -> MySQL
(3, 7), -- MySQL -> Оптимизация
(4, 2), -- JavaScript -> JavaScript
(4, 6); -- JavaScript -> Frontend