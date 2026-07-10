-- ============================================
-- MovieHub Entertainment Portal Database Schema
-- SQLite 3
-- ============================================

PRAGMA journal_mode = WAL;
PRAGMA foreign_keys = ON;
PRAGMA synchronous = NORMAL;

-- ============================================
-- ROLES
-- ============================================
CREATE TABLE IF NOT EXISTS roles (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(50) NOT NULL UNIQUE,
    slug VARCHAR(50) NOT NULL UNIQUE,
    description TEXT,
    permissions TEXT DEFAULT '[]',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- USERS
-- ============================================
CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role_id INTEGER DEFAULT 2,
    avatar VARCHAR(255),
    bio TEXT,
    country VARCHAR(100),
    language VARCHAR(50) DEFAULT 'en',
    timezone VARCHAR(50) DEFAULT 'UTC',
    email_verified_at DATETIME,
    last_login_at DATETIME,
    last_login_ip VARCHAR(45),
    status VARCHAR(20) DEFAULT 'active',
    reset_token VARCHAR(100),
    reset_expires_at DATETIME,
    notification_preferences TEXT DEFAULT '{"email":true,"push":true}',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE SET DEFAULT
);

-- ============================================
-- CATEGORIES
-- ============================================
CREATE TABLE IF NOT EXISTS categories (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    icon VARCHAR(100),
    color VARCHAR(20) DEFAULT '#3B82F6',
    status VARCHAR(20) DEFAULT 'active',
    sort_order INTEGER DEFAULT 0,
    meta_title VARCHAR(255),
    meta_description TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- GENRES
-- ============================================
CREATE TABLE IF NOT EXISTS genres (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    image VARCHAR(255),
    status VARCHAR(20) DEFAULT 'active',
    sort_order INTEGER DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- COUNTRIES
-- ============================================
CREATE TABLE IF NOT EXISTS countries (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    code VARCHAR(10) NOT NULL,
    continent VARCHAR(50),
    status VARCHAR(20) DEFAULT 'active',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- LANGUAGES
-- ============================================
CREATE TABLE IF NOT EXISTS languages (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    code VARCHAR(10) NOT NULL,
    status VARCHAR(20) DEFAULT 'active',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- ACTORS
-- ============================================
CREATE TABLE IF NOT EXISTS actors (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    biography TEXT,
    image VARCHAR(255),
    birth_date DATE,
    birth_place VARCHAR(255),
    nationality VARCHAR(100),
    status VARCHAR(20) DEFAULT 'active',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- DIRECTORS
-- ============================================
CREATE TABLE IF NOT EXISTS directors (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    biography TEXT,
    image VARCHAR(255),
    birth_date DATE,
    birth_place VARCHAR(255),
    nationality VARCHAR(100),
    status VARCHAR(20) DEFAULT 'active',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- TAGS
-- ============================================
CREATE TABLE IF NOT EXISTS tags (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    status VARCHAR(20) DEFAULT 'active',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- MOVIES
-- ============================================
CREATE TABLE IF NOT EXISTS movies (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title VARCHAR(500) NOT NULL,
    original_title VARCHAR(500),
    slug VARCHAR(500) NOT NULL UNIQUE,
    description TEXT,
    short_description TEXT,
    poster VARCHAR(255),
    banner VARCHAR(255),
    trailer_url VARCHAR(500),
    duration INTEGER DEFAULT 0,
    release_date DATE,
    imdb_rating REAL DEFAULT 0,
    user_rating REAL DEFAULT 0,
    rating_count INTEGER DEFAULT 0,
    view_count INTEGER DEFAULT 0,
    download_count INTEGER DEFAULT 0,
    like_count INTEGER DEFAULT 0,
    comment_count INTEGER DEFAULT 0,
    bookmark_count INTEGER DEFAULT 0,
    type VARCHAR(20) NOT NULL DEFAULT 'movie',
    category_id INTEGER,
    country_id INTEGER,
    language_id INTEGER,
    director_id INTEGER,
    status VARCHAR(20) DEFAULT 'published',
    published_at DATETIME,
    featured INTEGER DEFAULT 0,
    trending INTEGER DEFAULT 0,
    editor_pick INTEGER DEFAULT 0,
    quality VARCHAR(20) DEFAULT 'HD',
    is_adult INTEGER DEFAULT 0,
    seo_title VARCHAR(500),
    seo_description TEXT,
    seo_keywords TEXT,
    canonical_url VARCHAR(500),
    json_ld TEXT,
    created_by INTEGER,
    updated_by INTEGER,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
    FOREIGN KEY (country_id) REFERENCES countries(id) ON DELETE SET NULL,
    FOREIGN KEY (language_id) REFERENCES languages(id) ON DELETE SET NULL,
    FOREIGN KEY (director_id) REFERENCES directors(id) ON DELETE SET NULL,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL
);

-- ============================================
-- SERIES
-- ============================================
CREATE TABLE IF NOT EXISTS series (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title VARCHAR(500) NOT NULL,
    original_title VARCHAR(500),
    slug VARCHAR(500) NOT NULL UNIQUE,
    description TEXT,
    short_description TEXT,
    poster VARCHAR(255),
    banner VARCHAR(255),
    trailer_url VARCHAR(500),
    total_seasons INTEGER DEFAULT 0,
    total_episodes INTEGER DEFAULT 0,
    status VARCHAR(20) DEFAULT 'ongoing',
    release_date DATE,
    end_date DATE,
    imdb_rating REAL DEFAULT 0,
    user_rating REAL DEFAULT 0,
    rating_count INTEGER DEFAULT 0,
    view_count INTEGER DEFAULT 0,
    download_count INTEGER DEFAULT 0,
    like_count INTEGER DEFAULT 0,
    comment_count INTEGER DEFAULT 0,
    bookmark_count INTEGER DEFAULT 0,
    category_id INTEGER,
    country_id INTEGER,
    language_id INTEGER,
    director_id INTEGER,
    published_at DATETIME,
    featured INTEGER DEFAULT 0,
    trending INTEGER DEFAULT 0,
    editor_pick INTEGER DEFAULT 0,
    quality VARCHAR(20) DEFAULT 'HD',
    is_adult INTEGER DEFAULT 0,
    seo_title VARCHAR(500),
    seo_description TEXT,
    seo_keywords TEXT,
    canonical_url VARCHAR(500),
    json_ld TEXT,
    created_by INTEGER,
    updated_by INTEGER,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
    FOREIGN KEY (country_id) REFERENCES countries(id) ON DELETE SET NULL,
    FOREIGN KEY (language_id) REFERENCES languages(id) ON DELETE SET NULL,
    FOREIGN KEY (director_id) REFERENCES directors(id) ON DELETE SET NULL,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL
);

-- ============================================
-- EPISODES
-- ============================================
CREATE TABLE IF NOT EXISTS episodes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    series_id INTEGER NOT NULL,
    season INTEGER NOT NULL,
    episode_number INTEGER NOT NULL,
    title VARCHAR(500),
    description TEXT,
    duration INTEGER DEFAULT 0,
    air_date DATE,
    view_count INTEGER DEFAULT 0,
    download_count INTEGER DEFAULT 0,
    like_count INTEGER DEFAULT 0,
    imdb_rating REAL DEFAULT 0,
    thumbnail VARCHAR(255),
    video_url VARCHAR(500),
    status VARCHAR(20) DEFAULT 'published',
    published_at DATETIME,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (series_id) REFERENCES series(id) ON DELETE CASCADE,
    UNIQUE(series_id, season, episode_number)
);

-- ============================================
-- MOVIE_GENRES (Pivot)
-- ============================================
CREATE TABLE IF NOT EXISTS movie_genres (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    movie_id INTEGER,
    series_id INTEGER,
    genre_id INTEGER NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE,
    FOREIGN KEY (series_id) REFERENCES series(id) ON DELETE CASCADE,
    FOREIGN KEY (genre_id) REFERENCES genres(id) ON DELETE CASCADE,
    UNIQUE(movie_id, genre_id),
    UNIQUE(series_id, genre_id),
    CHECK (movie_id IS NOT NULL OR series_id IS NOT NULL)
);

-- ============================================
-- ACTOR_MOVIES (Pivot)
-- ============================================
CREATE TABLE IF NOT EXISTS actor_movies (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    actor_id INTEGER NOT NULL,
    movie_id INTEGER,
    series_id INTEGER,
    role VARCHAR(255),
    character_name VARCHAR(255),
    cast_order INTEGER DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (actor_id) REFERENCES actors(id) ON DELETE CASCADE,
    FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE,
    FOREIGN KEY (series_id) REFERENCES series(id) ON DELETE CASCADE,
    UNIQUE(actor_id, movie_id, series_id)
);

-- ============================================
-- DOWNLOAD_LINKS
-- ============================================
CREATE TABLE IF NOT EXISTS download_links (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    movie_id INTEGER,
    episode_id INTEGER,
    title VARCHAR(255) NOT NULL,
    url TEXT NOT NULL,
    quality VARCHAR(20) DEFAULT 'HD',
    file_size INTEGER DEFAULT 0,
    format VARCHAR(20) DEFAULT 'MP4',
    language VARCHAR(50),
    subtitles VARCHAR(255),
    is_working INTEGER DEFAULT 1,
    reported_count INTEGER DEFAULT 0,
    click_count INTEGER DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE,
    FOREIGN KEY (episode_id) REFERENCES episodes(id) ON DELETE CASCADE
);

-- ============================================
-- STREAMING_LINKS
-- ============================================
CREATE TABLE IF NOT EXISTS streaming_links (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    movie_id INTEGER,
    episode_id INTEGER,
    title VARCHAR(255) NOT NULL,
    url TEXT NOT NULL,
    quality VARCHAR(20) DEFAULT 'HD',
    format VARCHAR(20) DEFAULT 'MP4',
    language VARCHAR(50),
    is_working INTEGER DEFAULT 1,
    reported_count INTEGER DEFAULT 0,
    click_count INTEGER DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE,
    FOREIGN KEY (episode_id) REFERENCES episodes(id) ON DELETE CASCADE
);

-- ============================================
-- SCREENSHOTS
-- ============================================
CREATE TABLE IF NOT EXISTS screenshots (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    movie_id INTEGER,
    series_id INTEGER,
    image VARCHAR(255) NOT NULL,
    caption VARCHAR(255),
    sort_order INTEGER DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE,
    FOREIGN KEY (series_id) REFERENCES series(id) ON DELETE CASCADE
);

-- ============================================
-- TRAILERS
-- ============================================
CREATE TABLE IF NOT EXISTS trailers (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    movie_id INTEGER,
    series_id INTEGER,
    title VARCHAR(255) NOT NULL,
    url VARCHAR(500) NOT NULL,
    thumbnail VARCHAR(255),
    duration INTEGER DEFAULT 0,
    provider VARCHAR(50) DEFAULT 'youtube',
    sort_order INTEGER DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE,
    FOREIGN KEY (series_id) REFERENCES series(id) ON DELETE CASCADE
);

-- ============================================
-- RATINGS
-- ============================================
CREATE TABLE IF NOT EXISTS ratings (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    item_type VARCHAR(20) NOT NULL,
    item_id INTEGER NOT NULL,
    user_id INTEGER,
    rating INTEGER NOT NULL CHECK (rating >= 1 AND rating <= 5),
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE(item_type, item_id, user_id)
);

-- ============================================
-- COMMENTS
-- ============================================
CREATE TABLE IF NOT EXISTS comments (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    item_type VARCHAR(20) NOT NULL,
    item_id INTEGER NOT NULL,
    user_id INTEGER,
    parent_id INTEGER DEFAULT 0,
    author_name VARCHAR(255),
    author_email VARCHAR(255),
    content TEXT NOT NULL,
    status VARCHAR(20) DEFAULT 'published',
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (parent_id) REFERENCES comments(id) ON DELETE CASCADE
);

-- ============================================
-- BOOKMARKS
-- ============================================
CREATE TABLE IF NOT EXISTS bookmarks (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    item_type VARCHAR(20) NOT NULL,
    item_id INTEGER NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE(user_id, item_type, item_id)
);

-- ============================================
-- WATCH_HISTORY
-- ============================================
CREATE TABLE IF NOT EXISTS watch_history (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    item_type VARCHAR(20) NOT NULL,
    item_id INTEGER NOT NULL,
    episode_id INTEGER,
    progress INTEGER DEFAULT 0,
    duration INTEGER DEFAULT 0,
    watched_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (episode_id) REFERENCES episodes(id) ON DELETE CASCADE
);

-- ============================================
-- FEATURED_CONTENT
-- ============================================
CREATE TABLE IF NOT EXISTS featured_content (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    item_type VARCHAR(20) NOT NULL,
    item_id INTEGER NOT NULL,
    section VARCHAR(100) NOT NULL,
    sort_order INTEGER DEFAULT 0,
    label VARCHAR(255),
    start_date DATETIME,
    end_date DATETIME,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- MEDIA (uploaded videos & music)
-- ============================================
CREATE TABLE IF NOT EXISTS media (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    type VARCHAR(20) NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    file_path VARCHAR(255) NOT NULL,
    thumbnail VARCHAR(255),
    duration INTEGER DEFAULT 0,
    status VARCHAR(20) DEFAULT 'active',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- ANNOUNCEMENTS
-- ============================================
CREATE TABLE IF NOT EXISTS announcements (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title VARCHAR(500) NOT NULL,
    content TEXT NOT NULL,
    type VARCHAR(20) DEFAULT 'info',
    position VARCHAR(50) DEFAULT 'top',
    status VARCHAR(20) DEFAULT 'active',
    start_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    end_date DATETIME,
    priority INTEGER DEFAULT 0,
    created_by INTEGER,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
);

-- ============================================
-- ADVERTISEMENTS
-- ============================================
CREATE TABLE IF NOT EXISTS advertisements (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(255) NOT NULL,
    position VARCHAR(100) NOT NULL,
    code TEXT NOT NULL,
    image VARCHAR(255),
    url VARCHAR(500),
    alt_text VARCHAR(255),
    width INTEGER,
    height INTEGER,
    status VARCHAR(20) DEFAULT 'active',
    start_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    end_date DATETIME,
    click_count INTEGER DEFAULT 0,
    impression_count INTEGER DEFAULT 0,
    created_by INTEGER,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
);

-- ============================================
-- SITE_SETTINGS
-- ============================================
CREATE TABLE IF NOT EXISTS site_settings (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    `key` VARCHAR(255) NOT NULL UNIQUE,
    value TEXT,
    type VARCHAR(50) DEFAULT 'string',
    `group` VARCHAR(100) DEFAULT 'general',
    is_public INTEGER DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- AUDIT_LOGS
-- ============================================
CREATE TABLE IF NOT EXISTS audit_logs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER,
    action VARCHAR(255) NOT NULL,
    entity_type VARCHAR(100),
    entity_id INTEGER,
    old_values TEXT,
    new_values TEXT,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- ============================================
-- INDEXES
-- ============================================

-- Users
CREATE INDEX IF NOT EXISTS idx_users_email ON users(email);
CREATE INDEX IF NOT EXISTS idx_users_role_id ON users(role_id);
CREATE INDEX IF NOT EXISTS idx_users_status ON users(status);

-- Movies
CREATE INDEX IF NOT EXISTS idx_movies_slug ON movies(slug);
CREATE INDEX IF NOT EXISTS idx_movies_status ON movies(status);
CREATE INDEX IF NOT EXISTS idx_movies_type ON movies(type);
CREATE INDEX IF NOT EXISTS idx_movies_category_id ON movies(category_id);
CREATE INDEX IF NOT EXISTS idx_movies_country_id ON movies(country_id);
CREATE INDEX IF NOT EXISTS idx_movies_language_id ON movies(language_id);
CREATE INDEX IF NOT EXISTS idx_movies_director_id ON movies(director_id);
CREATE INDEX IF NOT EXISTS idx_movies_published_at ON movies(published_at);
CREATE INDEX IF NOT EXISTS idx_movies_featured ON movies(featured);
CREATE INDEX IF NOT EXISTS idx_movies_trending ON movies(trending);
CREATE INDEX IF NOT EXISTS idx_movies_view_count ON movies(view_count);
CREATE INDEX IF NOT EXISTS idx_movies_imdb_rating ON movies(imdb_rating);
CREATE INDEX IF NOT EXISTS idx_movies_release_date ON movies(release_date);

-- Series
CREATE INDEX IF NOT EXISTS idx_series_slug ON series(slug);
CREATE INDEX IF NOT EXISTS idx_series_status ON series(status);
CREATE INDEX IF NOT EXISTS idx_series_category_id ON series(category_id);
CREATE INDEX IF NOT EXISTS idx_series_country_id ON series(country_id);
CREATE INDEX IF NOT EXISTS idx_series_language_id ON series(language_id);
CREATE INDEX IF NOT EXISTS idx_series_trending ON series(trending);
CREATE INDEX IF NOT EXISTS idx_series_featured ON series(featured);

-- Episodes
CREATE INDEX IF NOT EXISTS idx_episodes_series_id ON episodes(series_id);
CREATE INDEX IF NOT EXISTS idx_episodes_season ON episodes(season);
CREATE INDEX IF NOT EXISTS idx_episodes_published_at ON episodes(published_at);

-- Movie Genres
CREATE INDEX IF NOT EXISTS idx_movie_genres_movie_id ON movie_genres(movie_id);
CREATE INDEX IF NOT EXISTS idx_movie_genres_series_id ON movie_genres(series_id);
CREATE INDEX IF NOT EXISTS idx_movie_genres_genre_id ON movie_genres(genre_id);

-- Actor Movies
CREATE INDEX IF NOT EXISTS idx_actor_movies_actor_id ON actor_movies(actor_id);
CREATE INDEX IF NOT EXISTS idx_actor_movies_movie_id ON actor_movies(movie_id);
CREATE INDEX IF NOT EXISTS idx_actor_movies_series_id ON actor_movies(series_id);

-- Comments
CREATE INDEX IF NOT EXISTS idx_comments_item ON comments(item_type, item_id);
CREATE INDEX IF NOT EXISTS idx_comments_user_id ON comments(user_id);
CREATE INDEX IF NOT EXISTS idx_comments_status ON comments(status);
CREATE INDEX IF NOT EXISTS idx_comments_created_at ON comments(created_at);

-- Ratings
CREATE INDEX IF NOT EXISTS idx_ratings_item ON ratings(item_type, item_id);
CREATE INDEX IF NOT EXISTS idx_ratings_user_id ON ratings(user_id);

-- Bookmarks
CREATE INDEX IF NOT EXISTS idx_bookmarks_user_id ON bookmarks(user_id);
CREATE INDEX IF NOT EXISTS idx_bookmarks_item ON bookmarks(item_type, item_id);

-- Watch History
CREATE INDEX IF NOT EXISTS idx_watch_history_user_id ON watch_history(user_id);
CREATE INDEX IF NOT EXISTS idx_watch_history_item ON watch_history(item_type, item_id);
CREATE INDEX IF NOT EXISTS idx_watch_history_watched_at ON watch_history(watched_at);

-- Featured Content
CREATE INDEX IF NOT EXISTS idx_featured_section ON featured_content(section);
CREATE INDEX IF NOT EXISTS idx_featured_sort_order ON featured_content(sort_order);

-- Ads
CREATE INDEX IF NOT EXISTS idx_ads_position ON advertisements(position);
CREATE INDEX IF NOT EXISTS idx_ads_status ON advertisements(status);

-- Categories
CREATE INDEX IF NOT EXISTS idx_categories_slug ON categories(slug);
CREATE INDEX IF NOT EXISTS idx_categories_status ON categories(status);

-- Genres
CREATE INDEX IF NOT EXISTS idx_genres_slug ON genres(slug);
CREATE INDEX IF NOT EXISTS idx_genres_status ON genres(status);

-- Countries
CREATE INDEX IF NOT EXISTS idx_countries_slug ON countries(slug);
CREATE INDEX IF NOT EXISTS idx_countries_status ON countries(status);

-- Actors
CREATE INDEX IF NOT EXISTS idx_actors_slug ON actors(slug);
CREATE INDEX IF NOT EXISTS idx_actors_status ON actors(status);

-- Directors
CREATE INDEX IF NOT EXISTS idx_directors_slug ON directors(slug);
CREATE INDEX IF NOT EXISTS idx_directors_status ON directors(status);

-- Site Settings
CREATE UNIQUE INDEX IF NOT EXISTS idx_site_settings_key ON site_settings(`key`);

-- Audit Logs
CREATE INDEX IF NOT EXISTS idx_audit_logs_user_id ON audit_logs(user_id);
CREATE INDEX IF NOT EXISTS idx_audit_logs_created_at ON audit_logs(created_at);
CREATE INDEX IF NOT EXISTS idx_audit_logs_entity ON audit_logs(entity_type, entity_id);
