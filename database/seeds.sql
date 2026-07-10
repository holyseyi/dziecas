-- ============================================
-- SEED DATA
-- ============================================

-- Roles
INSERT OR IGNORE INTO roles (id, name, slug, description, permissions) VALUES
(1, 'Administrator', 'admin', 'Full access to all features', '["*"]'),
(2, 'User', 'user', 'Regular user permissions', '["browse", "comment", "rate", "bookmark"]');

-- Categories
INSERT OR IGNORE INTO categories (name, slug, description, icon, color, sort_order) VALUES
('Action', 'action', 'High-octane action movies and series', 'film', '#EF4444', 1),
('Comedy', 'comedy', 'Funny movies and series', 'smile', '#F59E0B', 2),
('Horror', 'horror', 'Scary and suspenseful content', 'ghost', '#8B5CF6', 3),
('Romance', 'romance', 'Love stories and romantic comedies', 'heart', '#EC4899', 4),
('Thriller', 'thriller', 'Suspenseful and gripping stories', 'cube', '#3B82F6', 5),
('Crime', 'crime', 'Crime dramas and mysteries', 'shield', '#6366F1', 6),
('Animation', 'animation', 'Animated movies and series', 'play-circle', '#10B981', 7),
('Sci-Fi', 'sci-fi', 'Science fiction adventures', 'cpu', '#06B6D4', 8),
('Family', 'family', 'Family-friendly content', 'users', '#F97316', 9),
('Adventure', 'adventure', 'Exciting adventure stories', 'map', '#84CC16', 10),
('Documentary', 'documentary', 'Non-fiction documentaries', 'video', '#78716C', 11),
('Fantasy', 'fantasy', 'Magical fantasy worlds', 'sparkles', '#A855F7', 12),
('Mystery', 'mystery', 'Mystery and detective stories', 'help-circle', '#64748B', 13),
('War', 'war', 'War and military action', 'crosshair', '#DC2626', 14),
('History', 'history', 'Historical dramas', 'book', '#92400E', 15),
('Biography', 'biography', 'Biographical films', 'user-check', '#B45309', 16),
('Musical', 'musical', 'Musicals and music films', 'music', '#BE185D', 17),
('Drama', 'drama', 'Dramatic stories', 'film', '#334155', 18);

-- Genres
INSERT OR IGNORE INTO genres (name, slug, description, sort_order) VALUES
('Action', 'action', 'Action-packed scenes', 1),
('Comedy', 'comedy', 'Comedy and humor', 2),
('Horror', 'horror', 'Horror and thriller', 3),
('Romance', 'romance', 'Romantic stories', 4),
('Thriller', 'thriller', 'Thrilling suspense', 5),
('Crime', 'crime', 'Crime and detective', 6),
('Animation', 'animation', 'Animated content', 7),
('Science Fiction', 'science-fiction', 'Sci-fi adventures', 8),
('Family', 'family', 'Family-friendly', 9),
('Adventure', 'adventure', 'Adventure stories', 10),
('Documentary', 'documentary', 'Documentaries', 11),
('Fantasy', 'fantasy', 'Fantasy worlds', 12),
('Mystery', 'mystery', 'Mystery and suspense', 13),
('War', 'war', 'War and military', 14),
('History', 'history', 'Historical content', 15),
('Biography', 'biography', 'Biographical stories', 16),
('Musical', 'musical', 'Musicals', 17),
('Drama', 'drama', 'Dramatic stories', 18),
('Superhero', 'superhero', 'Superhero movies', 19),
('Western', 'western', 'Western films', 20);

-- Countries
INSERT OR IGNORE INTO countries (name, slug, code, continent) VALUES
('United States', 'usa', 'US', 'North America'),
('United Kingdom', 'uk', 'GB', 'Europe'),
('Nigeria', 'nigeria', 'NG', 'Africa'),
('India', 'india', 'IN', 'Asia'),
('Japan', 'japan', 'JP', 'Asia'),
('South Korea', 'south-korea', 'KR', 'Asia'),
('China', 'china', 'CN', 'Asia'),
('France', 'france', 'FR', 'Europe'),
('Germany', 'germany', 'DE', 'Europe'),
('Canada', 'canada', 'CA', 'North America'),
('Australia', 'australia', 'AU', 'Oceania'),
('Brazil', 'brazil', 'BR', 'South America'),
('Mexico', 'mexico', 'MX', 'North America'),
('Spain', 'spain', 'ES', 'Europe'),
('Italy', 'italy', 'IT', 'Europe');

-- Languages
INSERT OR IGNORE INTO languages (name, slug, code) VALUES
('English', 'english', 'en'),
('Spanish', 'spanish', 'es'),
('French', 'french', 'fr'),
('German', 'german', 'de'),
('Japanese', 'japanese', 'ja'),
('Korean', 'korean', 'ko'),
('Chinese', 'chinese', 'zh'),
('Hindi', 'hindi', 'hi'),
('Portuguese', 'portuguese', 'pt'),
('Yoruba', 'yoruba', 'yo'),
('Hausa', 'hausa', 'ha'),
('Igbo', 'igbo', 'ig');

-- Tags
INSERT OR IGNORE INTO tags (name, slug) VALUES
('blockbuster', 'blockbuster'),
('award-winning', 'award-winning'),
('trending', 'trending'),
('new-release', 'new-release'),
('classic', 'classic'),
('cult-favorite', 'cult-favorite'),
('indie', 'indie'),
('based-on-book', 'based-on-book'),
('true-story', 'true-story'),
('remake', 'remake');

-- Admin user (password: admin123)
INSERT OR IGNORE INTO users (id, username, email, password_hash, role_id, status) VALUES
(1, 'admin', 'admin@moviehub.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, 'active');

-- Site Settings
INSERT OR IGNORE INTO site_settings (`key`, value, type, `group`, is_public) VALUES
('site_name', 'MovieHub', 'string', 'general', 1),
('site_description', 'Watch the latest movies and TV series', 'string', 'general', 1),
('site_keywords', 'movies, tv series, streaming', 'string', 'general', 1),
('site_url', 'http://localhost', 'string', 'general', 1),
('maintenance_mode', '0', 'boolean', 'general', 0),
('items_per_page', '20', 'number', 'general', 0),
('trending_days', '7', 'number', 'general', 0),
('allow_registration', '1', 'boolean', 'general', 0),
('smtp_host', '', 'string', 'email', 0),
('smtp_port', '587', 'number', 'email', 0),
('smtp_username', '', 'string', 'email', 0),
('smtp_password', '', 'string', 'email', 0),
('facebook_url', '', 'string', 'social', 0),
('twitter_url', '', 'string', 'social', 0),
('instagram_url', '', 'string', 'social', 0),
('youtube_url', '', 'string', 'social', 0);
