# MovieHub - Entertainment Portal

A complete production-ready Movie & Entertainment Portal built with PHP 8.3+, SQLite, and Vanilla JavaScript.

## Features

- **Public Website**: Movies, TV Series, Anime, K-Dramas, Documentaries, Nollywood, Hollywood, Bollywood, Entertainment News
- **Categories & Genres**: Action, Comedy, Horror, Romance, Thriller, Crime, Animation, Sci-Fi, and more
- **Advanced Search**: Live AJAX Search with filters
- **User Authentication**: Registration, Login, Forgot Password, Profile, Avatar Upload
- **User Features**: Bookmarks, Watch History, Ratings, Comments, Dark Mode
- **Admin Dashboard**: Complete CMS for managing content
- **SEO Optimized**: Meta tags, OpenGraph, Schema.org, Sitemap
- **REST API**: JSON API for mobile apps and integrations
- **Advertisement System**: Scheduled ads with tracking
- **Security**: CSRF, XSS, Rate Limiting, Role-Based Access Control
- **Performance**: Lazy Loading, Query Caching, SQLite Index Optimization

## Technology Stack

- PHP 8.3+
- SQLite 3
- HTML5 / CSS3
- TailwindCSS (via CDN)
- Alpine.js (via CDN)
- Vanilla JavaScript (ES6)
- PDO with Prepared Statements
- MVC Architecture (No Frameworks)

## Requirements

- PHP 8.3 or higher
- SQLite3 extension
- Apache with mod_rewrite enabled
- XAMPP / WAMP / LAMP / MAMP

## Installation

1. Clone or download this repository to your web server directory (e.g., `/var/www/html/moviehub` or `htdocs/moviehub`).

2. Run the installation script:
   ```bash
   php install.php
   ```

3. Ensure the following directories are writable:
   ```bash
   chmod 755 database storage/uploads cache logs
   ```

4. Update `config/config.php` with your site URL:
   ```php
   'APP_URL' => 'http://localhost/moviehub',
   'DB_PATH' => __DIR__ . '/../database/database.sqlite',
   ```

5. Access the site at `http://localhost/moviehub`

## Default Credentials

- **Admin Panel**: http://localhost/moviehub/admin
- **Email**: admin@moviehub.com
- **Password**: admin123

## Project Structure

```
/app
  /controllers        # Controllers
  /models             # Model classes
  /views              # View templates
    /partials         # Reusable view fragments
  /helpers            # Helper classes
  /middleware         # Middleware classes
/config               # Configuration files
/database             # SQLite database and migrations
/public               # Entry point (index.php)
/storage              # Uploads and cache
/assets               # CSS, JS, images
/routes               # Route definitions
/cache                # File cache
/logs                 # Log files
/api                  # API endpoints
/core                 # Core framework classes
```

## API Endpoints

```
GET  /api/movies          - List movies
GET  /api/latest          - Latest uploads
GET  /api/trending        - Trending content
GET  /api/search?q=...    - Search
GET  /api/genres          - All genres
GET  /api/categories      - All categories
GET  /api/movie/{slug}    - Movie details
GET  /api/series          - TV Series
GET  /api/episodes        - Episodes list
GET  /api/settings        - Public settings
```

## Security

- CSRF Protection on all forms
- XSS Protection via `htmlspecialchars()`
- SQL Injection Protection via PDO prepared statements
- Password Hashing (bcrypt)
- Session Security (HTTP-only cookies)
- Login Rate Limiting
- File Upload Validation
- Admin Audit Logs
- Role-Based Access Control

## Performance

- SQLite WAL mode and cache optimization
- Image placeholders with lazy loading
- Server-side pagination
- AJAX-powered interactions
- Browser cache headers
- Gzip compression (via .htaccess)

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)

## Wasmer Deployment

This application is Wasmer-ready and can be deployed to the Wasmer edge runtime.

### Prerequisites

- [Wasmer CLI](https://docs.wasmer.com/installation) installed
- [Wasmer account](https://wasmer.io/) for deployment

### Local Development with Wasmer

1. Install Wasmer:
   ```bash
   curl https://get.wasmer.io -sSfL | sh
   ```

2. Run the app locally with Wasmer:
   ```bash
   wasmer run .
   ```

3. Access the app at `http://localhost:8000`

### Deploy to Wasmer

1. Push your code to a Git repository (GitHub, GitLab, etc.)

2. Deploy using Wasmer CLI:
   ```bash
   wasmer deploy .
   ```

3. Or deploy via [Wasmer Console](https://wasmer.io/):
   - Connect your repository
   - Set the build command: `php install.php`
   - Set the start command: `php -S 0.0.0.0:8000 -t public`
   - Add environment variables:
     - `APP_ENV=production`
     - `APP_DEBUG=false`

### Wasmer Configuration

The app includes the following Wasmer configuration files:

- `wasmer.toml` - Main Wasmer configuration
- `wasmer.json` - Deployment manifest
- `config/wasmer.php` - Wasmer-specific PHP configuration

### Environment Variables

| Variable | Description | Default |
|----------|-------------|---------|
| `APP_ENV` | Application environment | `production` |
| `APP_DEBUG` | Debug mode | `false` |
| `APP_URL` | Application URL | `http://localhost` |

### Notes

- The SQLite database is stored in the `database/` directory
- Uploaded files are stored in `storage/uploads/`
- Make sure the `database/`, `storage/`, `cache/`, and `logs/` directories are writable
- The app auto-initializes the database on first run if it doesn't exist

## License

This project is open source and available under the MIT License.

## Contributing

1. Follow PSR-12 coding standards
2. Test your changes thoroughly
3. Update documentation when necessary

## Disclaimer

This project is for educational and personal use only. Ensure you comply with copyright laws in your jurisdiction when using or modifying this software.
