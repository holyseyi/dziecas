FROM php:8.3-cli-alpine

RUN apk add --no-cache \
    libsqlite3 \
    libsqlite3-dev \
    && docker-php-ext-install pdo_sqlite

WORKDIR /app

COPY composer.json ./
RUN if [ -f composer.json ]; then \
        if command -v composer >/dev/null 2>&1; then \
            composer install --no-dev --no-scripts --no-autoloader; \
        fi; \
    fi

COPY . .

RUN mkdir -p database storage/uploads/{posters,banners,screenshots,trailers,avatars} cache logs

RUN if [ -f database/schema.sql ]; then \
        php -r "\$db=new PDO('sqlite:database/database.sqlite');\$schema=file_get_contents('database/schema.sql');\$queries=array_filter(array_map('trim',explode(';',\$schema)));foreach(\$queries as \$q){if(!empty(\$q)){try{\$db->exec(\$q);}catch(Exception \$e){}}}" 2>/dev/null || true; \
    fi

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
